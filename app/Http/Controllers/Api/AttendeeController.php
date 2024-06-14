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

    private $relationships = ['attendeeinfo' => 'user'];

    public function __construct()
    {
        // ensure authentication (login)
        $this->middleware('auth:sanctum' , ['except'=> ['index','show']]);
        // ensure rate limitting (rate limitter)
        $this->middleware('throttle:api' , ['only' => ['store' , 'destroy']]);
        // ensure authorization (policies)
        $this->authorizeResource(Attendee::class , 'attendee');
    }

    public function index(Event $event)
    {
        $attendees = $this->loadRelationships(
            $event->attendees()->latest() , $this->relationships
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    public function store(Request $request, Event $event )
    {
        $attendee = $this->loadRelationships(
            $event->attendees()->create([
                "user_id" => $request->user()->id
            ]), $this->relationships
        );

        return new AttendeeResource($attendee);
    }


    public function show(Event $event , Attendee $attendee)
    {
        return new AttendeeResource(
            $this->loadRelationships($attendee , $this->relationships)
        );
    }

    public function destroy(Event $event ,Attendee $attendee)
    {
        $attendee->delete();

        return response(status: 204);
    }
}
