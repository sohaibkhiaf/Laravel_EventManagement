<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController
{

    public function index(Event $event)
    {
        $attendees = $event->attendees()->latest();

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    public function store(Request $request, Event $event )
    {
        $attendee = $event->attendees()->create([
            "user_id" => 1
        ]);

        return new AttendeeResource($attendee);
    }


    public function show(Event $event , Attendee $attendee)
    {
        return new AttendeeResource($attendee);
    }


    public function update(Request $request , Attendee $attendee)
    {
        //
    }


    public function destroy(Event $event ,Attendee $attendee)
    {
        $attendee->delete();

        return response(status: 204);
    }
}
