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
        Schema::create('surveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            $table->string('topografi');
            $table->string('gambar_lahan')->nullable();
            $table->integer('luas_lahan');
            $table->string('jenis_lahan');
            $table->string('pemanfaatan');
            $table->string('kondisi_sekitar');
            $table->string('koor_a');
            $table->string('koor_b');
            $table->string('koor_c');
            $table->string('koor_d');
            $table->string('peruntukan');
            $table->string('no_ba')->nullable();
            $table->string('no_lhp')->nullable();
            $table->string('file_laporan')->nullable();
            // $table->string('file_ba')->nullable();
            // $table->string('file_lhp')->nullable();
            // $table->string('arsip')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        // Schema::table('surveis', function (Blueprint $table) {
        //     $table->dropForeign(['updated_by']);
        //     $table->dropColumn('updated_by');
        // });

        Schema::dropIfExists('surveis');
    }
};
