<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditQualityAssuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('quality_assurance')) {

            if(!Schema::hasColumn('quality_assurance', 'selimages')) //check whether users table has email column
            {
                Schema::table('quality_assurance', function (Blueprint $table) {
                    $table->string('selimages');
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
        if(Schema::hasColumn('quality_assurance', 'selimages')) //check whether users table has email column
        {
            Schema::table('quality_assurance', function (Blueprint $table) {
                $table->dropColumn('selimages');
            });
        }
    }
}
