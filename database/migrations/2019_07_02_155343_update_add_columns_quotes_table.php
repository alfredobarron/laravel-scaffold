<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddColumnsQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->integer('artist_id')->unsigned()->nullable()->after('artist');
            $table->foreign('artist_id')->references('id')->on('users');
            $table->integer('agent_id')->unsigned()->nullable()->after('agent');
            $table->foreign('agent_id')->references('id')->on('users');
            //$table->datetime('schedule')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
