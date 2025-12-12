<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallLog;

class CallLogController extends Controller
{
    public function index()
    {
        return view('call-logs.index');
    }

    public function show(CallLog $callLog)
    {
        return view('call-logs.show', compact('callLog'));
    }
}