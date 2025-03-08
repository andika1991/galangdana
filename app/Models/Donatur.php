<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'donaturs'; // Nama tabel dalam database

    protected $fillable = [
        'name',
        'fundraising_id',
        'total_amount',
        'notes',
        'phone_number',
        'is_paid',
        'proof',
    ];

    /**
     * Relasi ke Fundraising (Many to One)
     */
    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class, 'fundraising_id', 'id');
    }
}
