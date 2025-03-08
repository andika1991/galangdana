<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donaturs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama donatur
            $table->string('phone_number');
            $table->unsignedBigInteger('total_amount'); // Total donasi
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->boolean('is_paid'); // Status pembayaran
            $table->string('proof')->nullable(); // Bukti pembayaran (misalnya URL gambar)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaturs');
    }
};
