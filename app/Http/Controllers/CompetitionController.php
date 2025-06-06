<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Competition;
use App\Models\CompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    // ADMIN METHODS - Competition Management

    public function adminIndex(Request $request)
    {
        $status = $request->query('status');

        $competitions = Competition::with(['category', 'competitionRequests'])
            ->when($status, function ($query) use ($status) {
                return $query->whereHas('competitionRequests', function ($subQuery) use ($status) {
                    $subQuery->where('request_verified', $status);
                });
            })
            ->when($status == null, function ($query) {
                return $query->whereHas('competitionRequests', function ($subQuery) {
                    $subQuery->where('request_verified', 'approved');
                })
                    ->orWhereDoesntHave('competitionRequests');
            })
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.competitions._competitions_list', compact('competitions'));
        }

        return view('admin.competitions.index', compact('competitions'));
    }



    public function adminCreate()
    {
        $categories = Category::all();
        return view('admin.competitions.create', compact('categories'));
    }

    public function adminStore(Request $request)
    {
        $validated = $this->validateCompetition($request, true);
        $documentPath = $this->handleFileUpload($request, 'competition_document');

        Competition::create(array_merge($validated, [
            'competition_document' => $documentPath
        ]));

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition created successfully.');
    }

    public function adminShow($id)
    {
        $competition = Competition::with('category')->findOrFail($id);
        return view('admin.competitions.show', compact('competition'));
    }

    public function adminEdit($id)
    {
        $competition = Competition::findOrFail($id);
        $categories = Category::all();
        return view('admin.competitions.edit', compact('competition', 'categories'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $validated = $this->validateCompetition($request, true);
        $competition = Competition::findOrFail($id);

        $documentPath = $this->handleFileUpload($request, 'competition_document', $competition->competition_document);

        $competition->update(array_merge($validated, [
            'competition_document' => $documentPath
        ]));

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition updated successfully.');
    }

    public function adminDestroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition deleted successfully.');
    }

    // ADMIN METHODS - Request Management

    public function adminRequestIndex(Request $request)
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

    public function adminRequestShow($id)
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

    public function adminUpdateRequestStatus(Request $request, $id)
    {
        $request->validate([
            'request_verified' => 'required|in:approved,rejected'
        ]);

        $competitionRequest = CompetitionRequest::findOrFail($id);
        $competitionRequest->update(['request_verified' => $request->request_verified]);

        return back()->with('success', 'Request status updated.');
    }

    // USER METHODS - Student & Supervisor (Combined)

    public function userIndex()
    {
        $requests = CompetitionRequest::with('competition')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $viewPath = $this->getUserViewPath('index');
        return view($viewPath, compact('requests'));
    }

    public function userCreate()
    {
        $categories = Category::all();
        $viewPath = $this->getUserViewPath('create');
        return view($viewPath, compact('categories'));
    }

    public function userStore(Request $request)
    {
        $validated = $this->validateCompetition($request);
        $documentPath = $this->handleFileUpload($request, 'competition_document');

        $competition = Competition::create(array_merge($validated, [
            'competition_document' => $documentPath
        ]));

        CompetitionRequest::create([
            'user_id' => Auth::id(),
            'competition_id' => $competition->competition_id,
            'request_verified' => 'pending',
        ]);

        $redirectRoute = $this->getUserRedirectRoute('index');
        return redirect()->route($redirectRoute)
            ->with('success', 'Request submitted successfully.');
    }

    public function userEdit($id)
    {
        $request = CompetitionRequest::with('competition')
            ->where('user_id', Auth::id())
            ->where('competition_id', $id)
            ->firstOrFail();

        $categories = Category::all();
        $viewPath = $this->getUserViewPath('edit');
        return view($viewPath, compact('request', 'categories'));
    }

    public function userUpdate(Request $request, $id)
    {
        $validated = $this->validateCompetitionUpdate($request);
        $competition = Competition::findOrFail($id);

        // Verify user owns this competition request
        CompetitionRequest::where('competition_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $competition->update($validated);

        $redirectRoute = $this->getUserRedirectRoute('index');
        return redirect()->route($redirectRoute)
            ->with('success', 'Competition updated successfully.');
    }

    public function userDestroy($id)
    {
        $request = CompetitionRequest::where('competition_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->delete();

        $competition = Competition::findOrFail($id);
        $competition->delete();

        $redirectRoute = $this->getUserRedirectRoute('index');
        return redirect()->route($redirectRoute)
            ->with('success', 'Competition request deleted.');
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    private function validateCompetition(Request $request, bool $isAdmin = false)
    {
        $rules = [
            'category_id' => 'required|exists:categories,category_id',
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_start' => 'required|date',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => $isAdmin ? 'required|url|max:255' : 'nullable|url',
            'competition_document' => $isAdmin ? 'nullable|file|mimes:pdf,doc,docx|max:2048' : 'required|file|mimes:pdf,docx|max:2048',
        ];

        return $request->validate($rules);
    }

    private function validateCompetitionUpdate(Request $request)
    {
        return $request->validate([
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => 'nullable|url',
        ]);
    }

    private function handleFileUpload(Request $request, string $fieldName, string $existingPath = null)
    {
        if (!$request->hasFile($fieldName)) {
            return $existingPath;
        }

        $document = $request->file($fieldName);
        $fileName = time() . '_' . $document->getClientOriginalName();
        $document->move(public_path('documents/competitions'), $fileName);

        return 'documents/competitions/' . $fileName;
    }

    private function getUserViewPath(string $view)
    {
        $userRole = Auth::user()->role ?? 'student';
        return "{$userRole}.competitions.{$view}";
    }

    private function getUserRedirectRoute(string $action)
    {
        $userRole = Auth::user()->role ?? 'student';
        return "{$userRole}.competitions.{$action}";
    }
}
