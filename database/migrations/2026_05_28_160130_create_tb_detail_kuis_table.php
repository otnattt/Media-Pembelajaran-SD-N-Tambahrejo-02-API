<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_detail_kuis', function (Blueprint $table) {

            $table->id('id_detail_kuis');

            $table->unsignedBigInteger('id_kuis');

            $table->text('pertanyaan');

            $table->text('pilihan_a');

            $table->text('pilihan_b');

            $table->text('pilihan_c');

            $table->text('pilihan_d');

            $table->enum('jawaban', [
                'A',
                'B',
                'C',
                'D'
            ]);

            $table->integer('poin')
                ->default(10);

            $table->timestamps();

            $table->foreign('id_kuis')
                ->references('id_kuis')
                ->on('tb_kuis')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_detail_kuis');
    }
};
