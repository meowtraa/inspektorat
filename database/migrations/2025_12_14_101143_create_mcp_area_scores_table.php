<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mcp_area_scores', function (Blueprint $table) {
            $table->id();

            // FK ke master area MCP
            $table->foreignId('mcp_area_id')
                ->constrained('mcp_areas')
                ->cascadeOnDelete();

            // Tahun penilaian
            $table->integer('tahun');

            // Nilai / persentase MCP
            $table->decimal('persentase', 5, 2);

            $table->timestamps();

            // 1 area hanya boleh 1 nilai per tahun
            $table->unique(
                ['mcp_area_id', 'tahun'],
                'mcp_area_scores_unique_area_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mcp_area_scores');
    }
};
