<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (fillable)
     */
   protected $fillable = [
    'user_id',
    'produk_id', 
    'quantity',
    'alamat',
    'metode_pembayaran',
    'status',
];

    /**
     * Default nilai status saat pertama kali dibuat
     */
    protected $attributes = [
        'status' => 'Menunggu Konfirmasi',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Scope untuk mempermudah filter status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}