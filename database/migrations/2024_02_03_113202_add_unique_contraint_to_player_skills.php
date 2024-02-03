<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // make skills table duplicate free by design (and support the upsert helper)
        Schema::table('player_skills', function (Blueprint $table) {
            $table->unique(['player_id', 'skill'], 'player_skills_player_id_skill_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_skills', function (Blueprint $table) {
            $table->dropUnique('player_skills_player_id_skill_unique');
        });
    }
};
