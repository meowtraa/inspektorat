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
        Schema::create('mcp_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')
                ->constrained('mcp_areas')
                ->onDelete('cascade');
            $table->year('year')->default(date('Y'));
            $table->string('code')->nullable(); // contoh: 4.1.2.2.1
            $table->text('name');               // nama dokumen
            $table->boolean('is_complete')->default(false); // checklist
            $table->text('notes')->nullable();  // catatan verifikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcp_items');
    }
};
