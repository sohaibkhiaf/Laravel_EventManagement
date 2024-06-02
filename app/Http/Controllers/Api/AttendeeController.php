<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

    private $relations = ['attendeeinfo' => 'user'];

    public function __construct()
    {
        $this->middleware('auth:sanctum' , ['except'=> ['index','show']]);
        $this->authorizeResource(Attendee::class , 'attendee');
    }

    public function index(Event $event)
    {
        $attendees = $this->loadRelations(
            $event->attendees()->latest() , $this->relations
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    public function store(Request $request, Event $event )
    {
        $attendee = $event->attendees()->create([
            "user_id" => $request->user()->id
        ]);

        return new AttendeeResource($attendee);
    }


    public function show(Event $event , Attendee $attendee)
    {
        return new AttendeeResource(
            $this->loadRelations($attendee , $this->relations)
        );
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
