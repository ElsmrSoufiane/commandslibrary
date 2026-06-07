<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'conversation_id')) {
                try {
                    $table->dropForeign(['conversation_id']);
                } catch (\Exception $e) {
                    //
                }
                $table->dropColumn('conversation_id');
            }
        });

        Schema::table('messages', function (Blueprint $table) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL",
                [env('DB_DATABASE'), 'messages', 'chat_room_id']
            );

            if (empty($foreignKeys)) {
                $table->foreign('chat_room_id')->references('id')->on('chat_rooms')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        //
    }
};
