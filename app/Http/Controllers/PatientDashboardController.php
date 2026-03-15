<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $patient = auth('patient')->user();
        return view('patient.dashboard', compact('patient'));
    }
}
