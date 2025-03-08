<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundraiser extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'fundraisers'; // Nama tabel dalam database

    protected $fillable = [
        'user_id',
        'is_active',
    ];

    /**
     * Relasi ke User (Many to One)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke Fundraising (One to Many)
     */
    public function fundraisings()
    {
        return $this->hasMany(Fundraising::class, 'fundraiser_id', 'id');
    }
}
