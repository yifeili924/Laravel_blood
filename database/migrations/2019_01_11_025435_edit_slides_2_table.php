<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditSlides2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasColumn('slides', 'morphology_id')) //check whether users table has email column
        {
            Schema::table('slides', function (Blueprint $table) {
                $table->integer('morphology_id')->default(0);
            });
        }
        if(!Schema::hasColumn('slides', 'mcase_id')) //check whether users table has email column
        {
            Schema::table('slides', function (Blueprint $table) {
                $table->integer('mcase_id')->default(0);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn(['morphology_id', 'mcase_id']);
        });
    }
}
