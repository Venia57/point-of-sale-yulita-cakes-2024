<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_item',
        'total_harga',
        'diskon',
        'bayar',
        'diterima',
        'nama_kasir',
    ];

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->id_user = Auth::user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
