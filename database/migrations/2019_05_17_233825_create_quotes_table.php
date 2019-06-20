<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('capacity')->nullable();
            $table->string('schedule')->nullable();
            $table->string('place')->nullable();
            $table->string('origin')->nullable();
            $table->string('client')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('artist')->nullable();
            $table->string('artist_cost')->nullable();
            $table->string('agent')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('event_coordination')->nullable();
            $table->string('sound_installation')->nullable();
            $table->string('sold')->nullable();
            $table->string('invoice_required')->nullable();
            $table->string('number_invoices')->nullable();
            $table->string('method_payment')->nullable();
            $table->string('payment_dates')->nullable();
            $table->string('hotel')->nullable();
            $table->string('numbre_rooms')->nullable();
            $table->string('type_rooms')->nullable();
            $table->string('flights')->nullable();
            $table->string('type_flights')->nullable();
            $table->string('ground_transportation')->nullable();
            $table->string('ground_transportation_specifications')->nullable();
            $table->string('catering')->nullable();
            $table->string('camerino')->nullable();
            $table->string('rider')->nullable();
            $table->string('other')->nullable();
            $table->string('distribution_courtesies')->nullable();
            $table->string('coordinator_budget')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->nullable();
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
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
        Schema::dropIfExists('quotes');
    }
}
