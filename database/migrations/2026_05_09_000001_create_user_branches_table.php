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
        // Create pivot table
        Schema::create('user_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unique(['user_id', 'branch_id']);
        });

        // Migrate existing branch_id data from users into the pivot table
        DB::statement('
            INSERT INTO user_branches (user_id, branch_id, created_at, updated_at)
            SELECT id, branch_id, NOW(), NOW()
            FROM users
            WHERE branch_id IS NOT NULL
              AND deleted_at IS NULL
        ');

        // Drop the branch_id column from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add branch_id to users (restore single-branch behaviour)
        Schema::table('users', function (Blueprint $table) {
            $table->integer('branch_id')->nullable()->after('user_type_id');
        });

        // Copy the first branch back for each user
        DB::statement('
            UPDATE users u
            JOIN (
                SELECT user_id, MIN(branch_id) AS branch_id
                FROM user_branches
                GROUP BY user_id
            ) ub ON u.id = ub.user_id
            SET u.branch_id = ub.branch_id
        ');

        Schema::dropIfExists('user_branches');
    }
};
