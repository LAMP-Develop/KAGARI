<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSendFlagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('add_sites', function (Blueprint $table) {
            $table->boolean('send_flag')->default(0);
            $table->boolean('comparison_flag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_sites', function (Blueprint $table) {
            //
        });
    }
}
