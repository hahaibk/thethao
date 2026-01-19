<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sports', function (Blueprint $table) {
            // nếu CHƯA có image thì mở dòng này
            // $table->string('image')->nullable()->after('name');

            $table->integer('sort_order')
                  ->default(0)
                  ->after('image'); // nếu không có image thì đổi thành after('name')
        });
    }

    public function down(): void
    {
        Schema::table('sports', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
