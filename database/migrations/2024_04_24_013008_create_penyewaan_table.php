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
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->integer('penyewaan_id')->autoIncrement();
            $table->integer('penyewaan_pelanggan_id')->nullable(false);
            $table->date('penyewaan_tglsewa')->nullable(false);
            $table->date('penyewaan_tglkembali')->nullable(false);
            $table->enum('penyewaan_sttspembayaran',['Lunas','Belum Dibayar','DP'])->nullabe();
            $table->enum('penyewaan_sttskembali',['Sudah Kembali','Belum Kembali'])->nullabe();
            $table->integer('penyewaan_totalharga')->nullable(false);
            $table->timestamps();

            $table->foreign('penyewaan_pelanggan_id')->references('pelanggan_id')->on('pelanggan')
            ->onUpdate('cascade')->onDelete('cascade');
            
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
