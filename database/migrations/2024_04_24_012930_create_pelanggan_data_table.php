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
        Schema::create('pelanggan_data', function (Blueprint $table) {
            $table->integer('pelanggan_data_id')->autoIncrement();
            $table->integer('pelanggan_data_pelanggan_id')->nullable(false);
            $table->enum('pelanggan_data_jenis',['KTP','SIM'])->nullable(false);
            $table->string('pelanggan_data_file', 255)->nullable(false);
            $table->timestamps();

            $table->foreign('pelanggan_data_pelanggan_id')->references('pelanggan_id')->on('pelanggan')
            ->onUpdate('cascade')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
