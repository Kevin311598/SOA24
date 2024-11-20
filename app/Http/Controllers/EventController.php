<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Models\Torta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return Inertia::render("Admin/Event", compact("events"));
    }

    public function store(EventStoreRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('imagen_url')) {
            $filePath = $request->file('imagen_url')->store('tortas', "public");
            Storage::url($filePath);
            $validatedData['imagen_url'] = $filePath;
        }

        DB::transaction(function () use ($validatedData) {
            Event::create($validatedData);
        });
    }

    public function update(EventUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $event = Event::findOrFail($id);
        if ($request->hasFile('imagen_url')) {
            if ($event->imagen_url) {
                Storage::disk('public')->delete($event->imagen_url);
            }
            $filePath = $request->file('imagen_url')->store('tortas', "public");
            Storage::url($filePath);
            $validatedData['imagen_url'] = $filePath;
        }
        DB::transaction(function () use ($event, $validatedData) {
            $event->update($validatedData);
        });
    }


    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $event = Event::find($request->id);
            Storage::disk('public')->delete($event->imagen_url);
            $event->delete();
        });
    }
}
