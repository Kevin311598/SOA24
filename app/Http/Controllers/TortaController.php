<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TortaStoreRequest;
use App\Http\Requests\TortaUpdateRequest;
use App\Models\Torta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TortaController extends Controller
{
    public function index()
    {
        $tortas = Torta::all();
        return Inertia::render("Admin/Torta", compact("tortas"));
    }

    public function store(TortaStoreRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('imagen_url')) {
            $filePath = $request->file('imagen_url')->store('tortas', "public");
            Storage::url($filePath);
            $validatedData['imagen_url'] = $filePath;
        }

        DB::transaction(function () use ($validatedData) {
            Torta::create($validatedData);
        });
    }

    public function update(TortaUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $torta = Torta::findOrFail($id);
        if ($request->hasFile('imagen_url')) {
            if ($torta->imagen_url) {
                Storage::disk('public')->delete($torta->imagen_url);
            }
            $filePath = $request->file('imagen_url')->store('tortas', "public");
            Storage::url($filePath);
            $validatedData['imagen_url'] = $filePath;
        }
        DB::transaction(function () use ($torta, $validatedData) {
            $torta->update($validatedData);
        });
    }


    public function destroy(Request $request)
    {
        DB::transaction(function () use ($request) {
            $torta = Torta::find($request->id);
            Storage::disk('public')->delete($torta->imagen_url);
            $torta->delete();
        });
    }
}
