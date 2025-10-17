<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Bảng dashboards: lưu thông tin từng dashboard
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->default('My Dashboard');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Bảng dashboard_items: lưu các widget/note trong từng dashboard
        Schema::create('dashboard_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dashboard_id')->constrained('dashboards')->cascadeOnDelete();
            $table->foreignId('note_id')->nullable()->constrained('notes')->nullOnDelete();
            // $table->string('title')->nullable();
            // $table->longText('content')->nullable();
            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->integer('w')->default(4);
            $table->integer('h')->default(2);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_items');
        Schema::dropIfExists('dashboards');
    }
};
