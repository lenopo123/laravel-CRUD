<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('quantity');
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet', 'cod'])->default('transfer_bank')->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'metode_pembayaran']);
        });
    }
};