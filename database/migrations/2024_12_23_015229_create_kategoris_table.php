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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id(); // Kolom id
            $table->string('name'); // Nama kategori
            $table->text('description'); // Deskripsi kategori
            $table->integer('weight'); // Bobot kategori
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status kategori
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
