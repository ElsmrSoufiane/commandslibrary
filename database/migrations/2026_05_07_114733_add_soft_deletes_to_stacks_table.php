<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stacks', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Optionally add soft deletes to commands if needed
        Schema::table('commands', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('commands', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('stacks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
