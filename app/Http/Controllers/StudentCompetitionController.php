<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCompetitionController extends Controller
{
    public function index()
    {
        $requests = CompetitionRequest::with('competition')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('student.competitions.index', compact('requests'));
    }

    public function create()
    {
        return view('student.competitions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'competition_tittle' => 'required',
            'competition_description' => 'required',
            'competition_organizer' => 'required',
            'competition_level' => 'required', //regional, nasional, internasional
            'competition_registration_start' => 'required|date',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => 'nullable|url',
            'competition_document' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $document = $request->file('competition_document');
        $fileName = time() . '_' . $document->getClientOriginalName();
        $document->move(public_path('documents/competitions'), $fileName);
        $documentPath = 'documents/competitions/' . $fileName;


        $competition = Competition::create([
            'category_id' => $request->category_id,
            'competition_tittle' => $request->competition_tittle,
            'competition_description' => $request->competition_description,
            'competition_organizer' => $request->competition_organizer,
            'competition_level' => $request->competition_level,
            'competition_registration_start' => $request->competition_registration_start,
            'competition_registration_deadline' => $request->competition_registration_deadline,
            'competition_registration_link' => $request->competition_registion_link,
            'competition_document' => $documentPath,
        ]);

        CompetitionRequest::create([
            'user_id' => Auth::id(),
            'competition_id' => $competition->competition_id,
            'request_verified' => 'pending',
        ]);

        return redirect()->route('student.competitions.index')->with('success', 'Request submitted successfully.');
    }

    public function edit($id)
    {
        $request = CompetitionRequest::with('competition')
            ->where('user_id', Auth::id())
            ->where('competition_id', $id)
            ->firstOrFail();

        $categories = \App\Models\Category::all();
        return view('student.competitions.edit', compact('request', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'competition_tittle' => 'required',
            'competition_description' => 'required',
            'competition_organizer' => 'required',
            'competition_level' => 'required',
            'competition_registration_deadline' => 'required|date',
            'competition_registration_link' => 'nullable|url',
        ]);

        $competition = Competition::findOrFail($id);

        $competition->update([
            'competition_tittle' => $request->competition_tittle,
            'competition_description' => $request->competition_description,
            'competition_organizer' => $request->competition_organizer,
            'competition_level' => $request->competition_level,
            'competition_registration_deadline' => $request->competition_registration_deadline,
            'competition_registion_link' => $request->competition_registion_link,
        ]);

        return redirect()->route('student.competitions.index')->with('success', 'Competition updated successfully.');
    }

    public function destroy($id)
    {
        $request = CompetitionRequest::where('competition_id', $id)->where('user_id', Auth::id())->firstOrFail();
        $request->delete();

        $competition = Competition::findOrFail($id);
        $competition->delete();

        return redirect()->route('student.competitions.index')->with('success', 'Competition request deleted.');
    }
}
