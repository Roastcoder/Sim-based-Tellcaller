<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        return view('leads.index');
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        // Store lead logic
        return redirect()->route('leads.index');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        // Update lead logic
        return redirect()->route('leads.index');
    }

    public function destroy(Lead $lead)
    {
        // Delete lead logic
        return redirect()->route('leads.index');
    }
}