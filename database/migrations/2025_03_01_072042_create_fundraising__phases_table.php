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
        Schema::create('fundraising_phases', function (Blueprint $table) { // Perbaikan nama tabel
            $table->id();
            $table->foreignId('fundraising_id')->constrained('fundraisings')->onDelete('cascade'); // Perbaikan nama kolom
            $table->string('name'); // Nama tahap fundraising
            $table->boolean('photo')->default(false);
            $table->text('notes')->nullable(); // Catatan tambahan (opsional)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraising_phases'); // Perbaikan nama tabel
    }
};
