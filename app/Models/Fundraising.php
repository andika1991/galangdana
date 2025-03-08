<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundraising extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'fundraisings'; // Nama tabel dalam database

    protected $fillable = [
        'fundraiser_id',
        'category_id',
        'is_active',
        'has_finished',
        'name',
        'thumbnail',
        'about',
        'target_amount',
        'slug',
    ];

    /**
     * Relasi ke Fundraiser (Many to One)
     */
    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class, 'fundraiser_id', 'id');
    }

    /**
     * Relasi ke Category (Many to One)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Relasi ke Donatur (One to Many)
     */
    public function donaturs()
    {
        return $this->hasMany(Donatur::class, 'fundraising_id', 'id')->where('is_paid',1);
    }

    /**
     * Relasi ke Fundraising Phases (One to Many)
     */
    public function phases()
    {
        return $this->hasMany(FundraisingPhase::class, 'fundraising_id', 'id');
    }

    public function totalReachedAmount()
    {
        return $this->donaturs()->sum('total_amount');
    }

    public function withdrawals()
    {
        return $this->hasMany(FundraisingWithdrawal::class);
    }

    public function getPercentageAttribute(){
        $totalDonations=$this->totalReachedAmount();

        if($this->target_amount>0){
            $percentage = ($totalDonations/$this->target_amount)*100;
            return $percentage > 100 ? 100 : $percentage;
        }
        return 0;
    }
}
