<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_perolehan_nilai', function (Blueprint $table) {

            // FOREIGN KEY SISWA
            $table->foreign('id_siswa')
                ->references('id_siswa')
                ->on('tb_siswa')
                ->onDelete('cascade');

            // FOREIGN KEY KUIS
            $table->foreign('id_kuis')
                ->references('id_kuis')
                ->on('tb_kuis')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tb_perolehan_nilai', function (Blueprint $table) {

            $table->dropForeign(['id_siswa']);
            $table->dropForeign(['id_kuis']);
        });
    }
};
