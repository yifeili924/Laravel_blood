<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('comments')) {

            if(!Schema::hasColumn('comments', 'type')) //check whether users table has type column
            {
                Schema::table('comments', function (Blueprint $table) {
                    $table->string('type')->default('');
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
        if(Schema::hasColumn('comments', 'type')) //check whether users table has email column
        {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
}
