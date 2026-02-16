<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use Illuminate\Http\Request;

class GuichetController extends Controller
{
    public function index()
    {
        $guichets = Guichet::with('hopital')->get();

        return view('guichets.index', compact('guichets'));
    }

    public function open(Guichet $guichet)
    {
        $guichet->open();

        return back()->with('success', "Guichet {$guichet->nom} ouvert");
    }

    public function close(Guichet $guichet)
    {
        $guichet->close();

        return back()->with('success', "Guichet {$guichet->nom} fermé");
    }
}
