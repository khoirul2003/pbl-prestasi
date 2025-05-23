<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::with('category')->paginate(10);
        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.competitions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => 'required|url|max:255',
            'competition_document' => 'nullable|string|max:255',
        ]);

        Competition::create([
            'category_id' => $request->category_id,
            'competition_tittle' => $request->competition_tittle,
            'competition_description' => $request->competition_description,
            'competition_organizer' => $request->competition_organizer,
            'competition_level' => $request->competition_level,
            'competition_registration_deadline' => $request->competition_registration_deadline,
            'competition_registion_link' => $request->competition_registion_link,
            'competition_document' => $request->competition_document,
        ]);

        return redirect()->route('competitions.index')->with('success', 'Competition created successfully.');
    }

    public function show($id)
    {
        $competition = Competition::with('category')->findOrFail($id);
        return view('admin.competitions.show', compact('competition'));
    }

    public function edit($id)
    {
        $competition = Competition::findOrFail($id);
        $categories = Category::all();
        return view('admin.competitions.edit', compact('competition', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'competition_tittle' => 'required|string|max:255',
            'competition_description' => 'required|string',
            'competition_organizer' => 'required|string|max:255',
            'competition_level' => 'required|in:regional,nasional,internasional',
            'competition_registration_deadline' => 'required|date',
            'competition_registion_link' => 'required|url|max:255',
            'competition_document' => 'nullable|string|max:255',
        ]);

        $competition = Competition::findOrFail($id);
        $competition->update([
            'category_id' => $request->category_id,
            'competition_tittle' => $request->competition_tittle,
            'competition_description' => $request->competition_description,
            'competition_organizer' => $request->competition_organizer,
            'competition_level' => $request->competition_level,
            'competition_registration_deadline' => $request->competition_registration_deadline,
            'competition_registion_link' => $request->competition_registion_link,
            'competition_document' => $request->competition_document,
        ]);

        return redirect()->route('competitions.index')->with('success', 'Competition updated successfully.');
    }

    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();

        return redirect()->route('competitions.index')->with('success', 'Competition deleted successfully.');
    }
}
