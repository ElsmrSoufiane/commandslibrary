<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove duplicate (community_id, user_id) rows, keeping the oldest per pair
        DB::statement('
            DELETE FROM community_admins
            WHERE id NOT IN (
                SELECT * FROM (
                    SELECT MIN(id)
                    FROM community_admins
                    GROUP BY community_id, user_id
                ) AS keep_ids
            )
        ');

        Schema::table('community_admins', function (Blueprint $table) {
            $table->unique(['community_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_admins', function (Blueprint $table) {
            $table->dropUnique('community_admins_community_id_user_id_unique');
        });
    }
};
