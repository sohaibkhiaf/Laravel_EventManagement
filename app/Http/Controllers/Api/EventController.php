<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController
{

    public function index()
    {
        return Event::all();
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

        return $event;
    }


    public function show(Event $event)
    {
        return Event::find($event->id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
