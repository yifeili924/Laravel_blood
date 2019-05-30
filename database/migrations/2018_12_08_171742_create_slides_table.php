<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        if (Schema::hasTable('slides')) {
//            //
//            if(!Schema::hasColumn('slides', 'bucket_name')) //check whether users table has email column
//            {
//                Schema::table('slides', function (Blueprint $table) {
//                    $table->string('bucket_name');
//                });
//            }
//
//            if(!Schema::hasColumn('slides', 'name')) //check whether users table has email column
//            {
//                Schema::table('slides', function (Blueprint $table) {
//                    $table->string('name');
//                });
//            }
//
//        } else {
//
//        }
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bucket_name');
            $table->string('name');
            $table->string('sampletype');
            $table->string('slidename');
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
        Schema::dropIfExists('slides');
    }
}
