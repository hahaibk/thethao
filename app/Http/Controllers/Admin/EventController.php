<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('admin.home_sections.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.home_sections.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:500',
            'content'   => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('admin.homesection.events.index')
            ->with('success', 'Thêm event thành công');
    }

    public function edit(Event $event)
    {
        return view('admin.home_sections.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:500',
            'content'   => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) {
                Storage::disk('public')->delete($event->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.homesection.events.index')
            ->with('success', 'Cập nhật event thành công');
    }

    public function destroy(Event $event)
    {
        if ($event->thumbnail) {
            Storage::disk('public')->delete($event->thumbnail);
        }

        $event->delete();

        return back()->with('success', 'Đã xóa event');
    }
}
