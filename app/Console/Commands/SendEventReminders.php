<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notification to all event attendees that event starts soon';


    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_time' , [now() , now()->addDay()])
            ->get();

        $events->each(function($event) {
            $event->attendees->each(function ($attendee) {
                $this->info('Notifying the user '. $attendee->user_id );
                $attendee->user->notify(new EventReminderNotification($attendee->event));
            });
        });

        $eventsCount = $events->count();
        $eventLabel = Str::plural('event', $eventsCount);

        $this->info("Found ".$eventsCount." ".$eventLabel);
        
        $this->info("Reminders notifications sent successfully.");
    }
}
