<?php

namespace App\Http\Controllers\Quotes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quotes\Quotes;

class QuotesController extends Controller
{
    public function filter (Request $request)
    {
        $query = Quotes::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $quotes = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        return $quotes;
    }

    public function show ($quote)
    {
        return Quotes::findOrFail($quote);
    }

    public function store (Request $request)
    {
        $quote = Quotes::create([
            'type' => $request->type,
            'capacity' => $request->capacity,
            'schedule' => $request->schedule,
            'place' => $request->place,
            'origin' => $request->origin,
            'client' => $request->client,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'artist' => $request->artist,
            'artist_cost' => $request->artist_cost,
            'agent' => $request->agent,
            'agent_phone' => $request->agent_phone,
            'event_coordination' => $request->event_coordination,
            'sound_installation' => $request->sound_installation,
            'sold' => $request->sold,
            'invoice_required' => $request->invoice_required,
            'number_invoices' => $request->number_invoices,
            'method_payment' => $request->method_payment,
            'payment_dates' => $request->payment_dates,
            'hotel' => $request->hotel,
            'numbre_rooms' => $request->numbre_rooms,
            'type_rooms' => $request->type_rooms,
            'flights' => $request->flights,
            'type_flights' => $request->type_flights,
            'ground_transportation' => $request->ground_transportation,
            'ground_transportation_specifications' => $request->ground_transportation_specifications,
            'catering' => $request->catering,
            'camerino' => $request->camerino,
            'rider' => $request->rider,
            'distribution_courtesies' => $request->distribution_courtesies,
            'coordinator_budget' => $request->coordinator_budget,
            'notes' => $request->notes,
            'status' => $request->status
        ]);

        return Quotes::find($quote->id);
    }

    public function update (Request $request)
    {
        $quote = Quotes::find($request->id);
        $quote->type = $request->type;
        $quote->capacity = $request->capacity;
        $quote->schedule = $request->schedule;
        $quote->place = $request->place;
        $quote->origin = $request->origin;
        $quote->client = $request->client;
        $quote->client_email = $request->client_email;
        $quote->client_phone = $request->client_phone;
        $quote->artist = $request->artist;
        $quote->artist_cost = $request->artist_cost;
        $quote->agent = $request->agent;
        $quote->agent_phone = $request->agent_phone;
        $quote->event_coordination = $request->event_coordination;
        $quote->sound_installation = $request->sound_installation;
        $quote->sold = $request->sold;
        $quote->invoice_required = $request->invoice_required;
        $quote->number_invoices = $request->number_invoices;
        $quote->method_payment = $request->method_payment;
        $quote->payment_dates = $request->payment_dates;
        $quote->hotel = $request->hotel;
        $quote->numbre_rooms = $request->numbre_rooms;
        $quote->type_rooms = $request->type_rooms;
        $quote->flights = $request->flights;
        $quote->type_flights = $request->type_flights;
        $quote->ground_transportation = $request->ground_transportation;
        $quote->ground_transportation_specifications = $request->ground_transportation_specifications;
        $quote->catering = $request->catering;
        $quote->camerino = $request->camerino;
        $quote->rider = $request->rider;
        $quote->distribution_courtesies = $request->distribution_courtesies;
        $quote->coordinator_budget = $request->coordinator_budget;
        $quote->notes = $request->notes;
        $quote->status = $request->status;
        $quote->save();

        return Quotes::find($quote->id);
    }

    public function destroy ($quote)
    {
        return Quotes::destroy($quote);
    }
}
