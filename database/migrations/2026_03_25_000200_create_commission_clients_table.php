<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('commission_clients')) {
            Schema::create('commission_clients', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('password');
                $table->boolean('is_active')->default(true)->index();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('commission_clients');
    }
};
