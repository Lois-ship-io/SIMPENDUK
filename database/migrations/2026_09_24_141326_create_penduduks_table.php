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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 16);
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->foreignId('wilayah_id')->constrained('wilayahs')->cascadeOnDelete();
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->enum('agama', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->enum('status_perkawinan', ['Kawin', 'Belum Kawin', 'Cerai']);
            $table->string('pekerjaan');
            $table->string('kewarganegaraan');
            $table->string('no_telepon')->nullable();
            $table->enum('status', ['HIDUP', 'MATI'])->default('HIDUP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
