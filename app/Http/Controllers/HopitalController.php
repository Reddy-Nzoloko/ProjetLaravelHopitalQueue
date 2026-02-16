<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use Illuminate\Http\Request;

class HopitalController extends Controller
{
    public function index()
    {
        $hopitaux = Hopital::all();

        return view('hopitaux.index', compact('hopitaux'));
    }

    public function show(Hopital $hopital)
    {
        return view('hopitaux.show', compact('hopital'));
    }

    public function update(Request $request, Hopital $hopital)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'adresse' => 'nullable|string',
            'configuration' => 'nullable',
        ]);

        $hopital->update($data);

        return back()->with('success', 'Hôpital mis à jour');
    }
}
