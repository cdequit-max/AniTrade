<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 10)->default('buyer')->after('email'); // buyer | store
            $table->string('store_name')->nullable()->after('name');
            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'store_name', 'phone', 'address']);
        });
    }
};
