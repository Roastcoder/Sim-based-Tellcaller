<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AutoDialer;
use App\Models\Lead;

class AutoDialerController extends Controller
{
    public function index()
    {
        $dialers = AutoDialer::where('user_id', auth()->id())->get();
        return view('auto-dialer.index', compact('dialers'));
    }

    public function startCalling(Request $request)
    {
        $dialer = AutoDialer::where('user_id', auth()->id())->where('status', 'active')->first();
        
        if (!$dialer) {
            return response()->json(['error' => 'No active dialer found'], 400);
        }

        $leads = Lead::where('assigned_to', auth()->id())
                    ->where('status', 'pending')
                    ->limit(10)
                    ->get();

        return response()->json([
            'dialer' => $dialer,
            'leads' => $leads,
            'dispositions' => ['interested', 'not_interested', 'callback', 'no_answer', 'busy', 'invalid']
        ]);
    }

    public function logCall(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'disposition' => 'required|string',
            'duration' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        // Update lead status
        $lead = Lead::findOrFail($request->lead_id);
        $lead->update([
            'status' => $request->disposition,
            'notes' => $request->notes
        ]);

        // Update dialer stats
        $dialer = AutoDialer::where('user_id', auth()->id())->first();
        if ($dialer) {
            $dialer->increment('calls_made_today');
            $dialer->update(['last_call_at' => now()]);
        }

        return response()->json(['success' => true]);
    }
}