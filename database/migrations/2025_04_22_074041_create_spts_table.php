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
        Schema::create('spts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            //$table->foreignId('pegawais_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('no_surat');
            // $table->string('tujuan');
            $table->date('pelaksanaan');
            $table->date('penetapan')->nullable();
            $table->enum('status', ['peninjauan', 'ditetapkan', 'ditolak'])->default('peninjauan');
            $table->string('file_spt')->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spts');
    }
};
