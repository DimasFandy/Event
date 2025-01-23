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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama event
            $table->text('description')->nullable(); // Deskripsi event
            $table->dateTime('start_date'); // Tanggal mulai event
            $table->dateTime('end_date'); // Tanggal akhir event
            $table->string('status')->default('active'); // Status event
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
