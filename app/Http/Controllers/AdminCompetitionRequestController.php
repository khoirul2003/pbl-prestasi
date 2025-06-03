<?php

namespace App\Http\Controllers;

use App\Models\CompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminCompetitionRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $requests = CompetitionRequest::with(['user', 'competition.category'])
            ->when($status, function ($query) use ($status) {
                return $query->where('request_verified', $status);
            })
            ->latest()
            ->get();

        return view('admin.requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = CompetitionRequest::with(['user', 'competition.category'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'user_name' => $request->user->user_name,
                'title' => $request->competition->competition_tittle,
                'description' => $request->competition->competition_description,
                'organizer' => $request->competition->competition_organizer,
                'level' => $request->competition->competition_level,
                'category' => $request->competition->category->category_name,
                'document' => $request->competition->competition_document,
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'request_verified' => 'required|in:approved,rejected'
        ]);

        $competitionRequest = CompetitionRequest::findOrFail($id);
        $competitionRequest->update(['request_verified' => $request->request_verified]);

        return back()->with('success', 'Request status updated.');
    }


}
