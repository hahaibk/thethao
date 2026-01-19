<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->string('code')->unique(); // Mã hóa đơn
    $table->string('name');
    $table->string('phone');

    $table->string('province');
    $table->string('district');
    $table->string('ward');
    $table->string('address');

    $table->string('payment_method'); // cod | bank
    $table->integer('total');

    $table->string('status')->default('pending'); 
    // pending | paid | shipping | done | cancel

    $table->timestamps();
});

    }
    public function down(): void
    {
        //
    }
};
