<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use CanLoadRelationships;

    private $relationships = [
        'organizer' => 'user', 
        'attendees' => 'attendees', 
        'attendeeinfo' => 'attendees.user'
    ];


    public function __construct()
    {
        // ensure authentication (login)
        $this->middleware('auth:sanctum' , ['except'=> ['index','show']]);
        // ensure rate limitting (rate limitter)
        $this->middleware('throttle:api' , ['only' => ['store' , 'update', 'destroy']]);
        // ensure authorization (policies)
        $this->authorizeResource(Event::class , 'event');
    }


    public function index()
    {
        $events = $this->loadRelationships(Event::query() , $this->relationships);

        return EventResource::collection(
            $events->latest()->paginate()
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

        $event = Event::create([...$data , "user_id" => $request->user()->id]);

        return new EventResource($event);
    }
    public function show(Event $event)
    {
        return new EventResource($this->loadRelationships($event , $this->relationships));
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
