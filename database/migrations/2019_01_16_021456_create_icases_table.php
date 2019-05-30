<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icases', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime("publish_date");
            $table->dateTime("closing_date");
            $table->string('description');
            $table->integer('haemoglobin');
            $table->integer('whitecell');
            $table->integer('platelet');
            $table->string('explanation');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icases');
    }
}
