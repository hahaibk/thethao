<?php

// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $events = Event::latest()->paginate(9);
        return view('shop.events.show', compact('event'));
    }
}
