<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function all()
    {
        return Event::with('artist', 'creator', 'editor')->get();
    }

    public function byDay(Request $request)
    {
        $dt = Carbon::parse($request->date);
        return Event::with('artist', 'creator', 'editor')
            ->where('artist_id', $request->userId)
            ->whereDay('date', $dt->day)
            ->whereMonth('date', $dt->month)
            ->whereYear('date', $dt->year)
            ->get();
    }

    public function byUser(Request $request)
    {
        $dt = Carbon::parse($request->date);
        return Event::with('artist', 'creator', 'editor')
            ->where('artist_id', $request->userId)
            ->whereMonth('date', $dt->month)
            ->whereYear('date', $dt->year)
            ->get();
    }

    public function store (Request $request)
    {
        if ($request->type == 'bar') {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'schedule' => 'required|string',
                'place' => 'required|string',
                'artist' => 'required'
            ]);

            $event = Event::create([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'schedule' => $request->schedule,
                'place' => $request->place,
                'artist_id' => $request->artist['id']
            ]);
        } else {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'schedule' => 'required|string',
                'capacity' => 'required|string',
                'place' => 'required|string',
                'client' => 'required|string',
                'client_email' => 'required|email',
                'client_phone' => 'required|string',
                'artist' => 'required',
                'sound_installation' => 'required|string',
                'sold' => 'required|string',
                'invoice_required' => 'required|string'
            ]);

            $event = Event::create([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'schedule' => $request->schedule,
                'capacity' => $request->capacity,
                'place' => $request->place,
                'client' => $request->client,
                'client_email' => $request->client_email,
                'client_phone' => $request->client_phone,
                'artist_id' => $request->artist['id'],
                'sound_installation' => $request->sound_installation,
                'sold' => $request->sold,
                'invoice_required' => $request->invoice_required,
            ]);
        }

        return Event::with('artist', 'creator', 'editor')->find($event->id);
    }

    public function update (Request $request)
    {
        if ($request->type == 'bar') {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'schedule' => 'required|string',
                'place' => 'required|string',
                'artist' => 'required'
            ]);

            $event = Event::find($request->id);
            $event->type = $request->type;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->schedule = $request->schedule;
            $event->place = $request->place;
            $event->artist_id = $request->artist['id'];
            $event->save();
        } else {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'schedule' => 'required|string',
                'capacity' => 'required|string',
                'place' => 'required|string',
                'client' => 'required|string',
                'client_email' => 'required|email',
                'client_phone' => 'required|string',
                'artist' => 'required',
                'sound_installation' => 'required|string',
                'sold' => 'required|string',
                'invoice_required' => 'required|string'
            ]);

            $event = Event::find($request->id);
            $event->type = $request->type;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->schedule = $request->schedule;
            $event->capacity = $request->capacity;
            $event->place = $request->place;
            $event->client = $request->client;
            $event->client_email = $request->client_email;
            $event->client_phone = $request->client_phone;
            $event->artist_id = $request->artist['id'];
            $event->sound_installation = $request->sound_installation;
            $event->sold = $request->sold;
            $event->invoice_required = $request->invoice_required;
            $event->save();
        }

        return Event::with('artist', 'creator', 'editor')->find($event->id);
    }

    public function destroy ($user)
    {
        return Event::destroy($user);
    }
}
