<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();

            // $table->foreignIdFor(Event::class)->constrained('events')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignIdFor(Event::class);
            $table->foreignIdFor(User::class);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
