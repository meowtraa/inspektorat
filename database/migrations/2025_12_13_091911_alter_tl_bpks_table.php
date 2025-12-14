<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tl_bpk', function (Blueprint $table) {

            // kalau kolom lama gak kepake
            if (Schema::hasColumn('tl_bpk', 'persentase_tl')) {
                $table->dropColumn('persentase_tl');
            }

            $table->integer('jumlah_temuan')->default(0);
            $table->integer('jumlah_rekomendasi')->default(0);

            $table->integer('sesuai')->default(0);
            $table->integer('belum_sesuai')->default(0);
            $table->integer('belum_ditindaklanjuti')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('tl_bpk', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_temuan',
                'jumlah_rekomendasi',
                'sesuai',
                'belum_sesuai',
                'belum_ditindaklanjuti',
            ]);

            // balikin kalau mau
            $table->decimal('persentase_tl', 5, 2)->default(0);
        });
    }
};
