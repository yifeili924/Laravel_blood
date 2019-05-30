<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicDisplayToIcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icases', function (Blueprint $table) {
            $table->boolean("isdisplayed")->default(true);
        });
        Schema::table('icases', function (Blueprint $table) {
            $table->boolean("ispublic")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icases', function (Blueprint $table) {
            $table->dropColumn("ispublic");
        });
        Schema::table('icases', function (Blueprint $table) {
            $table->dropColumn("isdisplayed");
        });
    }
}
