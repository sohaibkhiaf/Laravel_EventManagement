<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{

    public function viewAny(?User $user): bool
    {
        // anyone can view all events / ?User means that authentication is not necessary
        return true;
    }


    public function view(?User $user, Event $event): bool
    {
        // anyone can view any event
        return true;
    }


    public function create(User $user): bool
    {
        // creating an event require authentication / login
        return true;
    }


    public function update(User $user, Event $event): bool
    {
        // auth required
        // only the organizer of the event can update it
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        // auth required
        // only the organizer of the event can delete it
        return $user->id === $event->user_id;
    }

}
