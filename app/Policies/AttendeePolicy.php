<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
{

    public function viewAny(?User $user): bool
    {
        // anyone can view all attendees / ?User means that authentication is not necessary
        return true;
    }

    public function view(?User $user, Attendee $attendee): bool
    {
        // anyone can view any attendee
        return true;
    }

    public function create(User $user): bool
    {
        // require authentication / login
        return true;
    }

    public function delete(User $user, Attendee $attendee): bool
    {
        // auth required
        // must be the organizer of the event that the attendee belongs to
        // or the attendee itself
        return $user->id === $attendee->event->user_id || $user->id === $attendee->user_id;
    }

}
