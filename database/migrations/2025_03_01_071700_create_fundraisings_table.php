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
        Schema::create('fundraisings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_id')->constrained('fundraisers')->onDelete('cascade'); // Relasi dengan tabel fundraisers
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Relasi dengan tabel categories
            $table->boolean('is_active'); // Status aktif
            $table->boolean('has_finished'); // Status selesai atau belum
            $table->string('name'); 
            $table->string('thumbnail'); 
            $table->text('about'); 
            $table->string('slug')->unique(); 
            $table->softDeletes();
            $table->unsignedBigInteger('target_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraisings');
    }
};
