<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreFundraisingWithdrawalsRequest;
use App\Http\Requests\UpdateFundraisingWithdrawalRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\FundraisingWithdrawal;
use App\Models\Fundraising;
class FundraisingWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fundraising_withdrawals= FundraisingWithdrawal::orderByDesc('id')->get();
        return view('admin.fundraising_withdrawals.index', compact('fundraising_withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingWithdrawalsRequest $request, Fundraising $fundraising)
    {
        // Pastikan tidak ada penarikan yang sudah ada untuk fundraising ini
        $hashRequestedWithdrawal = $fundraising->withdrawals()->exists();

        // Jika sudah ada, redirect kembali
        if ($hashRequestedWithdrawal) {
            return redirect()->route('admin.fundraising.show', $fundraising);
        }

        // Menggunakan transaksi untuk memastikan data konsisten
        DB::transaction(function() use ($request, $fundraising) {
            // Mendapatkan data yang sudah tervalidasi
            $validated = $request->validated();

            // Menambahkan kolom-kolom yang tidak ada di form
            $validated['fundraiser_id'] = Auth::user()->fundraiser->id;
            $validated['has_received'] = false;
            $validated['has_set'] = false;
            $validated['amount_requested'] = $fundraising->totalReachedAmount(); // Menggunakan total dana terkumpul
            $validated['amount_received'] = 0;  // Initial amount_received set ke 0
            $validated['proof'] = 'proof/buktipalsu.png'; // Jika proof tidak diupload, gunakan ini sebagai default
            $validated['has_finished']=false;
            // Menyimpan data penarikan
            $fundraising->withdrawals()->create($validated);
        });

        // Redirect ke halaman my withdrawals setelah berhasil menyimpan
        return redirect()->route('admin.fundraisings.show',$fundraising);
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingWithdrawal $FundraisingWithdrawal)
    {
        return view('admin.fundraising_withdrawals.show', compact('FundraisingWithdrawal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingWithdrawalRequest $request, FundraisingWithdrawal $FundraisingWithdrawal)
    {
        DB::transaction(function () use ($request, $FundraisingWithdrawal){
            $validated = $request->validated();

            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs','public');
                $validated['proof']=$proofPath;
            }
            $validated['has_set']=1;
            $FundraisingWithdrawal->update($validated);
        });
        return redirect()->route('admin.fundraising_withdrawals.show',$FundraisingWithdrawal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
