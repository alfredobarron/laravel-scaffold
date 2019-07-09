<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;

class EventController extends Controller
{
    public function all()
    {
        return Event::with('artist')->get();
    }

    public function byUser($userId)
    {
        return Event::with('artist')->where('artist_id', $userId)->get();
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
            'schedule' => 'required|date',
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
            'title' => $request->artist['name'],
            'description' => $request->description,
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

        return Event::with('artist')->find($event->id);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
            'schedule' => 'required|date',
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
        $event->title = $request->artist['name'];
        $event->description = $request->description;
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

        return Event::with('artist')->find($event->id);
    }

    public function destroy ($user)
    {
        return Event::destroy($user);
    }
}
