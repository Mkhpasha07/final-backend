<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyewaan_detail', function (Blueprint $table) {
            $table->integer('penyewaan_detail_id')->autoIncrement();
            $table->integer('penyewaan_detail_penyewaan_id')->nullable(false);
            $table->integer('penyewaan_detail_alat_id')->nullable(false);
            $table->integer('penyewaan_detail_jumlah')->nullable(false);
            $table->integer('penyewaan_detail_subharga')->nullable(false);
            $table->timestamps();

            $table->foreign('penyewaan_detail_penyewaan_id')->references('penyewaan_id')->on('penyewaan')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('penyewaan_detail_alat_id')->references('alat_id')->on('alat')
            ->onUpdate('cascade')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan_detail');
    }
};
