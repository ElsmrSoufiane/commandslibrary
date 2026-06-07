<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('frameworks', 'technologies');

        Schema::table('stacks', function (Blueprint $table) {
            $table->renameColumn('framework_id', 'technology_id');
        });
    }

    public function down(): void
    {
        Schema::table('stacks', function (Blueprint $table) {
            $table->renameColumn('technology_id', 'framework_id');
        });

        Schema::rename('technologies', 'frameworks');
    }
};
