<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_kuis', function (Blueprint $table) {

            $table->id('id_kuis');

            $table->unsignedBigInteger('id_guru');

            $table->string('judul');

            $table->text('deskripsi')
                ->nullable();

            $table->enum('status', [
                'aktif',
                'draft'
            ])->default('draft');

            $table->dateTime('tanggal_dibuat')
                ->useCurrent();

            $table->integer('total_soal')
                ->default(0);

            $table->timestamps();

            $table->foreign('id_guru')
                ->references('id_guru')
                ->on('tb_guru')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_kuis');
    }
};
