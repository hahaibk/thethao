<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('sport_id')
                  ->nullable()
                  ->after('category_id')
                  ->constrained()
                  ->nullOnDelete();

            $table->enum('gender', ['male','female','unisex'])
                  ->default('unisex')
                  ->after('sport_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['sport_id']);
            $table->dropColumn(['sport_id','gender']);
        });
    }
};

