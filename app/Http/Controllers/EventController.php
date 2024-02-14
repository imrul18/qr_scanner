<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    public function eventList(Request $request)
    {
        $events = Event::query();
        if ($request->has('search')) {
            $events = $events->where('name', 'like', '%' . $request->search . '%');
        }
        $events = $events->paginate('10');
        return view('pages.events.list', compact('events', 'request'));
    }

    public function eventAddPage()
    {
        return view('pages.events.add');
    }

    public function eventAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);
        $data = $request->only(['name']);
        $event = Event::create($data);
        if ($event) {
            return redirect()->route('event-list-page')->with('success', 'Event added successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function eventEditPage($id)
    {
        $event = Event::find($id);
        return view('pages.events.edit', compact('event'));
    }

    public function eventEdit(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'status' => 'required',
        ]);
        $data = $request->only(['name', 'status']);

        $event = Event::find($id)->update($data);
        if ($event) {
            return redirect()->route('event-list-page')->with('success', 'Event update successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function eventDelete($id)
    {
        $event = Event::find($id)->delete();
        if (!$event) {
            return redirect()->back()->with('error', 'Something wents wrong!');
        }
        return redirect()->route('event-list-page')->with('success', 'Event delete successfully!');
    }

    public function eventViewPage($id)
    {
        $event = Event::find($id);
        return view('pages.events.view', compact('event'));
    }
}
