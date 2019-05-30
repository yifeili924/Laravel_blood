<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('information')) {
            Schema::table('information', function (Blueprint $table) {
                $table->string('haemo');
            });
        } else {
            Schema::create('information', function (Blueprint $table) {
                $table->increments('id');
                $table->string('mcq_emq');
                $table->string('essay');
                $table->string('morphology');
                $table->string('quality_assurance');
                $table->string('transfusion');
                $table->string('haemo');
                $table->timestamps();
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
        Schema::table('information', function (Blueprint $table) {
            $table->dropColumn('haemo');
        });
    }
}
