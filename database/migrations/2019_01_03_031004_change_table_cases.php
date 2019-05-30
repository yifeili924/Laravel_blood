<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cases')) {
            Schema::create('cases', function (Blueprint $table) {
                $table->increments('id');
                $table->string('description');
                $table->string('catagory');
                $table->string('slides');
                $table->timestamps();
            });
        }

        Schema::rename("cases", "mcases");
        Schema::table('mcases', function (Blueprint $table) {
            $table->dropColumn('slides');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('mcases')) {
            Schema::rename("mcases", "cases");
            Schema::table('cases', function (Blueprint $table) {
                $table->string('slides')->default("");
            });
        }
    }
}
