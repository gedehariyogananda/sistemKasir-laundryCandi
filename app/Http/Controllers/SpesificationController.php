<?php

namespace App\Http\Controllers;

use App\Models\Spesification;

class SpesificationController extends Controller
{
    public function index()
    {
        $spesifications = Spesification::all();
        return view('spesifications.index', compact('spesifications'));
    }
}
