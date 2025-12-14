<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mcp_area_scores', function (Blueprint $table) {
            $table->decimal('bobot', 5, 2)
                ->default(0)
                ->after('persentase')
                ->comment('Bobot MCP Area per Tahun (%)');
        });
    }

    public function down(): void
    {
        Schema::table('mcp_area_scores', function (Blueprint $table) {
            $table->dropColumn('bobot');
        });
    }
};