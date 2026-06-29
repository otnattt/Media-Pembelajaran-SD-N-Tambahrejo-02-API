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
        Schema::create('tb_videoPembelajaran', function (Blueprint $table) {

            $table->id('id_vidpem');

            $table->unsignedBigInteger('id_guru');

            $table->string('judul');

            $table->string('file_video');

            $table->enum('status_video', ['aktif', 'nonaktif'])
                  ->default('aktif');

            $table->timestamps();

            // relasi ke tb_guru
            $table->foreign('id_guru')
                  ->references('id_guru')
                  ->on('tb_guru')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_videoPembelajaran');
    }
};
