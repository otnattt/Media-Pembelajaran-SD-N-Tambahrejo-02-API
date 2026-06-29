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
        Schema::create('tb_jawaban_siswa', function (Blueprint $table) {
            $table->bigIncrements('id_jawaban_siswa');

            $table->unsignedBigInteger('id_detail_kuis');
            $table->unsignedBigInteger('id_siswa');

            $table->text('jawaban_siswa');
            $table->integer('perolehan_point')->default(0);

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_detail_kuis')
                  ->references('id_detail_kuis')
                  ->on('tb_detail_kuis')
                  ->onDelete('cascade');

            $table->foreign('id_siswa')
                  ->references('id_siswa')
                  ->on('tb_siswa')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_jawaban_siswa');
    }
};
