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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->string('nama')->unique();
            // $table->string('no_hp');
            $table->string('id_pendaftaran')->unique();
            $table->string('atas_nama')->default('-')->nullable();
            $table->string('alamat_jalan');
            $table->string('alamat_kelurahan');
            $table->string('alamat_kecamatan');
            $table->string('lokasi_jalan');
            $table->string('lokasi_kelurahan');
            $table->string('lokasi_kecamatan');
            $table->integer('luas_lahan');
            $table->string('penggunaan');
            $table->string('kepemilikan');
            $table->enum('status', ['diterima', 'ditetapkan', 'survei', 'laporan', 'selesai'])->default('diterima');
            $table->string('no_surat')->unique();
            $table->string('file_surat');
            $table->date('tanggal_masuk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
