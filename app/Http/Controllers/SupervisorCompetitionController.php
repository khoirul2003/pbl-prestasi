<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorCompetitionController extends Controller
{
    public function index()
    {
        $requests = CompetitionRequest::with('competition')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('supervisor.competitions.index', compact('requests'));
    }

    public function create()
    {
        return view('supervisor.competitions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'competition_tittle' => 'required',
            'competition_description' => 'required',
            'competition_organizer' => 'required',
            'competition_level' => 'required',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => 'nullable|url',
            'competition_document' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $documentPath = $request->file('competition_document')->store('documents', 'public');

        $competition = Competition::create([
            'category_id' => $request->category_id,
            'competition_tittle' => $request->competition_tittle,
            'competition_description' => $request->competition_description,
            'competition_organizer' => $request->competition_organizer,
            'competition_level' => $request->competition_level,
            'competition_registration_deadline' => $request->competition_registration_deadline,
            'competition_registion_link' => $request->competition_registion_link,
            'competition_document' => $documentPath,
        ]);

        CompetitionRequest::create([
            'user_id' => Auth::id(),
            'competition_id' => $competition->competition_id,
            'request_verified' => 'pending',
        ]);

        return redirect()->route('supervisor.competitions.index')->with('success', 'Request submitted successfully.');
    }
}
