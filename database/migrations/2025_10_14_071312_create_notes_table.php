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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 255)->nullable();
            $table->string('note_title', 255);
            $table->longText('note_text')->nullable();
            $table->longText('note_code')->nullable();
            $table->enum('note_type', ['text', 'code', 'sql', 'image', 'mixed'])->default('text');
            // $table->string('note_image_path')->nullable();
            $table->string('keywords', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
