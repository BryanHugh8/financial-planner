<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->decimal('limit_amount', 10, 2);
            $table->integer('month');
            $table->integer('year');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'category_id', 'month', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('budgets');
    }
};
