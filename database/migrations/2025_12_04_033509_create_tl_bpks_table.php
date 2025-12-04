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
        Schema::create('tl_bpk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_skpd');
            $table->decimal('persentase_tl', 5, 2)->default(0);
            $table->integer('tahun');
            $table->tinyInteger('semester');
            $table->timestamps();

            // Unique gabungan
            $table->unique(
                ['nama_skpd', 'tahun', 'semester'],
                'tl_bpk_unique_skpd_tahun_semester'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tl_bpk');
    }
};
