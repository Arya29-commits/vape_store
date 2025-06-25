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
        Schema::create('barangs', function (Blueprint $table) {
            // PASTIKAN ANDA MENGGUNAKAN $table->id() DI SINI
            // Ini akan membuat kolom 'id' dengan tipe data BIGINT UNSIGNED
            $table->id();

            $table->string('nama_barang');
            
            // Sesuaikan 'id_kategori' dengan nama kolom foreign key Anda ke tabel kategoris
            $table->foreignId('id_kategori')->constrained('kategoris');
            
            $table->integer('harga');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};