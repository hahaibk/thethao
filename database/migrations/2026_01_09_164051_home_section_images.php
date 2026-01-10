<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_section_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_section_id')
                  ->constrained('home_sections')
                  ->onDelete('cascade'); // Xóa ảnh khi section bị xóa
            $table->string('image_path'); // đường dẫn ảnh
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_section_images');
    }
};
