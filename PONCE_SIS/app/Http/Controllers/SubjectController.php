<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:subjects,code',
            'name' => 'required|string|unique:subjects,name',
            'units' => 'required|integer|min:1|max:6',
            'description' => 'required|string'
        ], [
            'code.unique' => 'This subject code is already in use.',
            'name.unique' => 'This subject name is already in use.'
        ]);

        try {
            Subject::create($request->all());
            return redirect()->route('subjects.index')
                ->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to create subject. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'code' => 'required|max:10|unique:subjects,code,' . $subject->id,
            'name' => 'required|max:255',
            'units' => 'required|integer|min:1',
        ]);
    
        $subject->update($validated);
    
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->status === 'verified') {
            return back()->with('error', 'Cannot delete a verified subject.');
        }

        // Check if subject has any enrollments
        if ($subject->enrollments()->exists()) {
            return back()->with('error', 'Cannot delete subject because it has active enrollments. Please unenroll all students first.');
        }

        // Check if subject has any grades
        if ($subject->grades()->exists()) {
            return back()->with('error', 'Cannot delete subject because it has existing grades.');
        }

        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
    
}
