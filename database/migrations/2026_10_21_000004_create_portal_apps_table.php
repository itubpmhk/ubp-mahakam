<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category', 60)->default('Umum');
            $table->text('description')->nullable();
            $table->string('url', 2048);
            $table->string('thumbnail_path')->nullable();
            $table->boolean('open_new_tab')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_apps');
    }
};
