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
    Schema::create('input_aspirasis', function (Blueprint $table) {
        $table->integer('id_pelaporan')->autoIncrement();
        $table->string('nis', 20); // Ubah ke string, samakan panjangnya
        $table->integer('id_kategori');
        $table->string('lokasi', 50);
        $table->string('ket', 50);
        $table->timestamps();

        $table->foreign('nis')->references('nis')->on('siswas')->onDelete('cascade');
        $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_aspirasis');
    }
};
