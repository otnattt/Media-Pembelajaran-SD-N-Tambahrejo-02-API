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
        Schema::create('tb_perolehan_nilai', function (Blueprint $table) {

            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_kuis');

            $table->bigIncrements('id_perolehan_nilai');

            $table->unsignedBigInteger('id_jawaban_siswa');

            $table->integer('total_nilai')->default(0);

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_jawaban_siswa')
                  ->references('id_jawaban_siswa')
                  ->on('tb_jawaban_siswa')
                  ->onDelete('cascade');


                  $table->foreign('id_siswa')
                    ->references('id_siswa')
                    ->on('tb_siswa')
                    ->onDelete('cascade');

                $table->foreign('id_kuis')
                    ->references('id_kuis')
                    ->on('tb_kuis')
                    ->onDelete('cascade');

                    $table->integer('percobaan')->default(1);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_perolehan_nilai');
    }
};
