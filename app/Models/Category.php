<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'categories'; // Nama tabel dalam database

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    /**
     * Relasi dengan Fundraising (One to Many)
     */
    public function fundraisings()
    {
        return $this->hasMany(Fundraising::class, 'category_id', 'id');
    }
}
