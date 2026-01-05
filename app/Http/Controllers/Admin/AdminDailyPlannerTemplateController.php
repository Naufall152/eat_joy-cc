<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyPlannerTemplate;
use Illuminate\Http\Request;

class AdminDailyPlannerTemplateController extends Controller
{
    public function index()
    {
        $items = DailyPlannerTemplate::orderBy('plan')
            ->orderBy('day')
            ->get();

        return view('admin.planner.index', compact('items'));
    }

    public function create()
    {
        return view('admin.planner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan'  => 'required|in:starter,starter_plus',
            'day'   => 'required|integer|min:1|max:31',
            'title' => 'required|string|max:150',
            'tasks' => 'required|string', // textarea 1 baris = 1 task
        ]);

        $tasksArray = array_values(array_filter(array_map(
            'trim',
            preg_split("/\r\n|\n|\r/", $validated['tasks'])
        )));

        DailyPlannerTemplate::create([
            'plan'  => $validated['plan'],
            'day'   => $validated['day'],
            'title' => $validated['title'],
            'tasks' => $tasksArray,
        ]);

        return redirect()->route('admin.planner.index')->with('success', 'Template dibuat.');
    }

    public function edit(DailyPlannerTemplate $template)
    {
        return view('admin.planner.edit', compact('template'));
    }

    public function update(Request $request, DailyPlannerTemplate $template)
    {
        $validated = $request->validate([
            'plan'  => 'required|in:starter,starter_plus',
            'day'   => 'required|integer|min:1|max:31',
            'title' => 'required|string|max:150',
            'tasks' => 'required|string',
        ]);

        $tasksArray = array_values(array_filter(array_map(
            'trim',
            preg_split("/\r\n|\n|\r/", $validated['tasks'])
        )));

        $template->update([
            'plan'  => $validated['plan'],
            'day'   => $validated['day'],
            'title' => $validated['title'],
            'tasks' => $tasksArray,
        ]);

        return redirect()->route('admin.planner.index')->with('success', 'Template diupdate.');
    }

    public function destroy(DailyPlannerTemplate $template)
    {
        $template->delete();
        return back()->with('success', 'Template dihapus.');
    }
}
