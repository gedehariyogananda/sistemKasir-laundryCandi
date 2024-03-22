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
        Schema::create('user_purchaseds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('spesification_id')->nullable();
            $table->string('quantity_laundry');
            $table->date('tanggal_pengajuan_laundry');
            $table->date('tanggal_selesai_laundry');
            $table->string('subtotal_laundry')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->string('status_laundry')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_purchaseds');
    }
};
