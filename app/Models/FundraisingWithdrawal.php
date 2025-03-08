<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundraisingWithdrawal extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'fundraising_withdrawals'; // Nama tabel dalam database

    protected $fillable = [
        'fundraising_id',
        'fundraiser_id',
        'has_received',
        'has_set',
        'has_finished',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'proof',
        'amount_requested',
        'amount_received',
    ];

    /**
     * Relasi ke Fundraising (Many to One)
     */
    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class, 'fundraising_id', 'id');
    }

    /**
     * Relasi ke Fundraiser (Many to One)
     */
    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class, 'fundraiser_id', 'id');
    }
}
