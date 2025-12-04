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
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            // Primary Key untuk identitas OPD  

            $table->string('name')->unique();
            // Nama OPD (harus unik → tidak boleh duplicate)

            $table->enum('category', ['dinas', 'kecamatan', 'desa', 'unknown'])
                ->default('unknown');
            // Kategori OPD untuk filtering di dashboard
            // unknown jika berasal dari import pertama kali

            $table->timestamps();
            // created_at & updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opds');
    }
};
