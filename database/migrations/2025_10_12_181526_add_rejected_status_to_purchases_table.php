<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe data kolom status untuk menambahkan opsi "Ditolak"
        DB::statement("ALTER TABLE purchases MODIFY COLUMN status ENUM('Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak', 'Sedang Dikemas', 'Sedang Dikirim', 'Selesai') DEFAULT 'Menunggu Konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke nilai sebelumnya jika rollback
        DB::statement("ALTER TABLE purchases MODIFY COLUMN status ENUM('Menunggu Konfirmasi', 'Sedang Dikemas', 'Sedang Dikirim', 'Selesai') DEFAULT 'Menunggu Konfirmasi'");
    }
};