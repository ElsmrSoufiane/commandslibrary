<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "New Project Setup", "Database Setup", "Run Dev Server"
            $table->text('description')->nullable();
            $table->foreignId('framework_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0);
            $table->foreignId('stack_id')->constrained()->onDelete('cascade');
            $table->string('command'); // The actual command to run
            $table->text('description')->nullable(); // What this command does // Order within the stack
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commands');
        Schema::dropIfExists('stacks');
    }
};