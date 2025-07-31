<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['currency', 'date_format', 'notifications', 'budget_alerts']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('currency')->default('IDR')->after('email');
            $table->string('date_format')->default('d/m/Y')->after('currency');
            $table->boolean('notifications')->default(true)->after('date_format');
            $table->boolean('budget_alerts')->default(true)->after('notifications');
        });
    }
};
