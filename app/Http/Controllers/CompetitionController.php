<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Competition;
use App\Models\CompetitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{

    public function adminIndex(Request $request)
    {
        $status = $request->query('status');

        $competitions = Competition::with(['category', 'competitionRequests'])
            ->when($status, function ($query) use ($status) {
                return $query->whereHas('competitionRequests', function ($q) use ($status) {
                    $q->where('request_verified', $status);
                });
            })
            ->when(is_null($status), function ($query) {
                return $query->whereHas('competitionRequests', function ($q) {
                    $q->where('request_verified', 'approved');
                })->orWhereDoesntHave('competitionRequests');
            })
            ->paginate(10);

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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Competition updated successfully.']);
        }

        return redirect()->route('admin.competitions.index')->with('success', 'Competition updated successfully.');
    }

    public function adminDestroy($id)
    {
        $competition = Competition::findOrFail($id);

        $competition->delete();

        return redirect()->route('admin.competitions.index')->with('success', 'Competition deleted successfully.');
    }


    // ========================
    // REQUEST MANAGEMENT (ADMIN)
    // ========================

    public function adminRequestIndex(Request $request)
    {
        $status = $request->query('status');

        $requests = CompetitionRequest::with(['user', 'competition.category'])
            ->when($status, fn($q) => $q->where('request_verified', $status))
            ->latest()
            ->get();

        return view('admin.requests.index', compact('requests'));
    }

    public function adminRequestShow($id)
    {
        $request = CompetitionRequest::with(['user', 'competition.category'])->findOrFail($id);

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

    // ========================
    // USER METHODS
    // ========================

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

        return redirect()->route($this->getUserRedirectRoute('index'))
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

        CompetitionRequest::where('competition_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail(); // Authorization check

        $competition = Competition::findOrFail($id);
        $competition->update($validated);

        return redirect()->route($this->getUserRedirectRoute('index'))
            ->with('success', 'Competition updated successfully.');
    }

    public function userDestroy($id)
    {
        $request = CompetitionRequest::where('competition_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->delete();

        Competition::findOrFail($id)->delete();

        return redirect()->route($this->getUserRedirectRoute('index'))
            ->with('success', 'Competition request deleted.');
    }

    // ========================
    // HELPER METHODS
    // ========================

    private function validateCompetition(Request $request, bool $isAdmin = false)
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_start' => 'required|date',
            'competition_registration_deadline' => 'required|date',
            'competition_registration_link' => $isAdmin ? 'required|url|max:255' : 'nullable|url',
            'competition_document' => $isAdmin
                ? 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
                : 'required|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
        ]);
    }

    private function validateCompetitionUpdate(Request $request)
    {
        return $request->validate([
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_deadline' => 'required|date',
            'competition_registration_link' => 'nullable|url|max:255',
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
        $userRole = strtolower(Auth::user()->role ?? 'student');
        return "{$userRole}.competitions.{$view}";
    }

    private function getUserRedirectRoute(string $action)
    {
        $userRole = strtolower(Auth::user()->role ?? 'student');
        return "{$userRole}.competitions.{$action}";
    }


}
