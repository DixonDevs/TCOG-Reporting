<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Display all reports for the logged-in user, filtered by their permissions
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $reports = Report::all();
        } elseif ($user->hasRole('pastor')) {
            $reports = Report::where('church_id', $user->church_id)->get();
        } elseif ($user->hasRole('overseer')) {
            $reports = Report::whereIn('church_id', $user->churches)->get();
        } else {
            $reports = Report::where('user_id', $user->id)->get();
        }

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        // Show the form for creating a new report
        return view('reports.create');
    }

    public function store(Request $request)
    {
        // Store a new report
        $request->validate([
            'report_data' => 'required',
            // other validations
        ]);

        $report = Report::create([
            'user_id' => auth()->user()->id,
            'report_data' => $request->report_data,
            'church_id' => auth()->user()->church_id, // if applicable
        ]);

        return redirect()->route('reports.index');
    }

    public function view(Report $report)
    {
        // Show a specific report
        return view('reports.view', compact('report'));
    }
}
