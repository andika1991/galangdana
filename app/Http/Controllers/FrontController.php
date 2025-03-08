<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Fundraising;
use App\Models\Donatur;
use App\Http\Requests\StoreDonationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $categories= Category::all();
        $fundraisings = Fundraising::with(['category','fundraiser'])->where('is_active',1)->orderByDesc('id')->get();
        return view('front.views.index',compact('categories','fundraisings'));
    }

    public function category(Category $category){
       
        return view('front.views.category',compact('category'));
    }

    public function details(Fundraising $fundraising){
       $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;
        return view('front.views.details',compact('fundraising','goalReached'));
    }

    public function support(Fundraising $fundraising){
       
         return view('front.views.donation',compact('fundraising'));
     }

     public function checkout(Fundraising  $fundraising , $totalAmountDonation){
       
        return view('front.views.checkout',compact('fundraising','totalAmountDonation'));
    }

    public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation)
{
    DB::beginTransaction();

    try {
        // Validasi input dari request
        $validated = $request->validated();

        // Jika ada file bukti pembayaran (proof), simpan ke storage
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        // Tambahkan data tambahan sebelum menyimpan ke database
        $validated['fundraising_id'] = $fundraising->id;
        $validated['total_amount'] = $totalAmountDonation;
        $validated['is_paid'] = false;

        // Simpan data donatur ke database
        Donatur::create($validated);

        // Commit transaksi jika tidak ada error
        DB::commit();

        // Redirect ke halaman detail dengan pesan sukses
        return redirect()->route('front.details', $fundraising->slug)
                         ->with('success', 'Donation successfully recorded!');
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();

        // Redirect kembali dengan pesan error
        return redirect()->back()->with('error', 'Failed to process donation. Please try again.');
    }
}

}
