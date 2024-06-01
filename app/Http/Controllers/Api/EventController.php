<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController
{

    public function index()
    {
        return EventResource::collection(
            Event::with('user')->paginate()
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "start_time" => "required|date",
            "end_time" => "required|date|after:start_time",
        ]);

        $event = Event::create([...$data , "user_id" => 1]);

        return new EventResource($event);
    }


    public function show(Event $event)
    {
        return new EventResource($event->load(['user' , 'attendees']));
    }


    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            "name" => "sometimes|string|max:255",
            "description" => "nullable|string",
            "start_time" => "sometimes|date",
            "end_time" => "sometimes|date|after:start_time",
        ]);

        $event = Event::find($event->id);
        $event->update($data);

        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response(status: 204);
    }
}
