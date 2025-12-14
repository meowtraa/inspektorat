<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tl_kabs', function (Blueprint $table) {

            // DROP kolom persentase_tl
            if (Schema::hasColumn('tl_kabs', 'persentase_tl')) {
                $table->dropColumn('persentase_tl');
            }

            if (! Schema::hasColumn('tl_kabs', 'jumlah_temuan')) {
                $table->integer('jumlah_temuan')->default(0)->after('nama_skpd');
            }

            if (! Schema::hasColumn('tl_kabs', 'jumlah_rekomendasi')) {
                $table->integer('jumlah_rekomendasi')->default(0)->after('jumlah_temuan');
            }

            if (! Schema::hasColumn('tl_kabs', 'sesuai')) {
                $table->integer('sesuai')->default(0)->after('jumlah_rekomendasi');
            }

            if (! Schema::hasColumn('tl_kabs', 'belum_sesuai')) {
                $table->integer('belum_sesuai')->default(0)->after('sesuai');
            }

            if (! Schema::hasColumn('tl_kabs', 'belum_ditindaklanjuti')) {
                $table->integer('belum_ditindaklanjuti')->default(0)->after('belum_sesuai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tl_kabs', function (Blueprint $table) {

            $table->dropColumn([
                'jumlah_temuan',
                'jumlah_rekomendasi',
                'sesuai',
                'belum_sesuai',
                'belum_ditindaklanjuti',
            ]);

            $table->decimal('persentase_tl', 5, 2)->default(0)->after('nama_skpd');
        });
    }
};
