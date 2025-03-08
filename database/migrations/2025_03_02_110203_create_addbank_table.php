<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('fundraising_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraising_id')->constrained('fundraisings')->onDelete('cascade');
            $table->foreignId('fundraiser_id')->constrained('fundraisers')->onDelete('cascade');
            $table->boolean('has_received')->default(false);
            $table->boolean('has_set')->default(false);
            $table->integer('amount_requested');
            $table->integer('amount_received');
            $table->string('bank_name');
            $table->string('proof');
            $table->string('bank_account_number');
            $table->string('bank_account_name');
            $table->string('has_finished');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraising_withdrawals');
    }
};
