<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('currency', 10)->default('IDR');
            $table->string('date_format')->default('Y-m-d');
            $table->boolean('notifications')->default(true);
            $table->boolean('budget_alerts')->default(true);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['currency', 'date_format', 'notifications', 'budget_alerts']);
        });
    }
};
