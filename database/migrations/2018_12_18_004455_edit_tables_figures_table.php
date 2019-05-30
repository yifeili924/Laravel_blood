<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTablesFiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tablesfigures')) {

            if(!Schema::hasColumn('tablesfigures', 'bucket_name')) //check whether users table has email column
            {
                Schema::table('tablesfigures', function (Blueprint $table) {
                    $table->string('bucket_name');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('tablesfigures', 'bucket_name')) //check whether users table has email column
        {
            Schema::table('tablesfigures', function (Blueprint $table) {
                $table->dropColumn('bucket_name');
            });
        }
    }
}
