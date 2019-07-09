<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddColumnsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->datetime('schedule')->nullable()->default(null)->after('user_id');
            $table->string('capacity')->nullable()->after('schedule');
            $table->string('place')->nullable()->after('capacity');
            $table->string('client')->nullable()->after('place');
            $table->string('client_email')->nullable()->after('client');
            $table->string('client_phone')->nullable()->after('client_email');
            $table->integer('artist_id')->unsigned()->nullable()->after('client_phone');
            $table->foreign('artist_id')->references('id')->on('users');
            $table->string('sound_installation')->nullable()->after('artist_id');
            $table->string('sold')->nullable()->after('sound_installation');
            $table->string('invoice_required')->nullable()->after('sold');
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
