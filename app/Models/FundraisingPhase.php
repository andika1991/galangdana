<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundraisingPhase extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'fundraising_phases'; // Nama tabel dalam database

    protected $fillable = [
        'fundraising_id',
        'name',
        'photo',
        'notes',
    ];

    /**
     * Relasi ke Fundraising (Many to One)
     */
    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class, 'fundraising_id', 'id');
    }
}
