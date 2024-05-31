<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            // $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignIdFor(User::class);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
