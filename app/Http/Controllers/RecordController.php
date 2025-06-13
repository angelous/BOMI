<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecordController extends Controller
{

    public function index(): View
    {
        $records = Record::where('user_id', Auth::id())->get();
        return view('records.index', compact('records'));
    }

    public function create(): View
    {
        return view('records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|string',
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $heightInMeters = $validated['height'] / 100;
        $bmi = $validated['weight'] / ($heightInMeters ** 2);

        Record::create([
            'user_id' => Auth::id(),
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'weight' => $validated['weight'],
            'height' => $validated['height'],
            'bmi' => round($bmi, 2),
        ]);

        return redirect()->back()->with('success', 'Successfully Tracked.');
    }
}