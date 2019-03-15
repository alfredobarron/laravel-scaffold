<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;

class EventController extends Controller
{
    public function all()
    {
        return Event::with('user')->get();
    }

    public function byUser($userId)
    {
        return Event::with('user')->where('user_id', $userId)->get();
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'description' => 'required|string',
            'user' => 'required'
        ]);

        $event = Event::create([
            'date' => $request->date,
            'title' => $request->user['name'],
            'description' => $request->description,
            'user_id' => $request->user['id']
        ]);

        return Event::with('user')->find($event->id);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'description' => 'required|string',
            'user' => 'required'
        ]);

        $event = Event::find($request->id);
        $event->date = $request->date;
        $event->title = $request->user['name'];
        $event->description = $request->description;
        $event->user_id = $request->user['id'];
        $event->save();

        return Event::with('user')->find($event->id);
    }

    public function destroy ($user)
    {
        return Event::destroy($user);
    }
}
