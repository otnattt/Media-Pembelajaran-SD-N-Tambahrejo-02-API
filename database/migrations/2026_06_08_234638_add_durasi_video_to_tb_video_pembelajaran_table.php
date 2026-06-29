<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_videoPembelajaran', function (Blueprint $table) {
            $table->string('durasi_video')->nullable()->after('file_video');
        });
    }

    public function down(): void
    {
        Schema::table('tb_videoPembelajaran', function (Blueprint $table) {
            $table->dropColumn('durasi_video');
        });
    }
};
