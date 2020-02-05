<?php

namespace App\Http\Controllers\Quotes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quotes\Quotes;
use Carbon\Carbon;
use App\Exports\QuotesExport;
use Maatwebsite\Excel\Facades\Excel;

class QuotesController extends Controller
{
    public function filter (Request $request)
    {
        $query = Quotes::query();

        if ($request->agentId) {
            $query->where('agent_id', $request->agentId);
        }

        if ($request->artist) {
            $query->where('artist_id', $request->artist['id']);
        }

        if ($request->date) {
            $ds = Carbon::parse($request->date['dateRange']['start']['date']);
            $de = Carbon::parse($request->date['dateRange']['end']['date']);
            $query->whereBetween('date', [$ds, $de]);
        }

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $quotes = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    //->paginate($request->input('pagination.per_page'));
                    ->get();

        return $quotes;
    }

    public function show ($quote)
    {
        return Quotes::with('artist', 'agent')->findOrFail($quote);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'capacity' => 'required|string',
            'date' => 'required|date',
            'schedule' => 'required|string',
            'place' => 'required|string',
            'origin' => 'required|string',
            'client' => 'required|string',
            'client_email' => 'required|email',
            'client_phone' => 'required|string',
            'artist' => 'required',
            'artist_cost' => 'required|string',
            'agent' => 'required',
            'agent_phone' => 'required|string',
            'event_coordination' => 'required|string',
            'sound_installation' => 'required|string',
            'sold' => 'required|string',
            'invoice_required' => 'required|string',
            'number_invoices' => 'required|string',
            'method_payment' => 'required|string',
            'payment_dates' => 'required|string',
            'status' => 'required|string',
            'notes' => 'required|string',
        ]);

        $quote = Quotes::create([
            'type' => $request->type,
            'capacity' => $request->capacity,
            'date' => $request->date,
            'schedule' => $request->schedule,
            'place' => $request->place,
            'origin' => $request->origin,
            'client' => $request->client,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'artist' => $request->artist['name'],
            'artist_id' => $request->artist['id'],
            'artist_cost' => $request->artist_cost,
            'agent' => $request->agent['name'],
            'agent_id' => $request->agent['id'],
            'agent_phone' => $request->agent_phone,
            'event_coordination' => $request->event_coordination,
            'sound_installation' => $request->sound_installation,
            'sold' => $request->sold,
            'invoice_required' => $request->invoice_required,
            'number_invoices' => $request->number_invoices,
            'method_payment' => $request->method_payment,
            'payment_dates' => $request->payment_dates,
            'status' => $request->status,
            'notes' => $request->notes,
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
            'coordinator_budget' => $request->coordinator_budget
        ]);

        return Quotes::find($quote->id);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'capacity' => 'required|string',
            'date' => 'required|date',
            'schedule' => 'required|string',
            'place' => 'required|string',
            'origin' => 'required|string',
            'client' => 'required|string',
            'client_email' => 'required|email',
            'client_phone' => 'required|string',
            'artist' => 'required',
            'artist_cost' => 'required|string',
            'agent' => 'required',
            'agent_phone' => 'required|string',
            'event_coordination' => 'required|string',
            'sound_installation' => 'required|string',
            'sold' => 'required|string',
            'invoice_required' => 'required|string',
            'number_invoices' => 'required|string',
            'method_payment' => 'required|string',
            'payment_dates' => 'required|string',
            'status' => 'required|string',
            'notes' => 'required|string',
        ]);

        $quote = Quotes::find($request->id);
        $quote->type = $request->type;
        $quote->capacity = $request->capacity;
        $quote->date = $request->date;
        $quote->schedule = $request->schedule;
        $quote->place = $request->place;
        $quote->origin = $request->origin;
        $quote->client = $request->client;
        $quote->client_email = $request->client_email;
        $quote->client_phone = $request->client_phone;
        $quote->artist = $request->artist['name'];
        $quote->artist_id = $request->artist['id'];
        $quote->artist_cost = $request->artist_cost;
        $quote->agent = $request->agent['name'];
        $quote->agent_id = $request->agent['id'];
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

    public function countPendientes (Request $request)
    {
        $query = Quotes::query();

        if ($request->userId) {
            $query->where('agent_id', $request->userId);
        }

        $quotes = $query->where('status', 'Pendiente')->count();

        return $quotes;
    }

    public function export(Request $request)
    {
        $quotes = $this->filter($request);

        foreach ($quotes as $key => $value) {
            $data[] = [
                $value->date,
                $value->place,
                $value->client,
                $value->client_phone,
                $value->artist,
                $value->artist_cost,
                $value->agent,
                $value->origin,
                $value->status,
                $value->notes,
            ];
        }

        $export = new QuotesExport($data);

        return Excel::download($export, 'cotizaciones.xlsx');
    }
}
