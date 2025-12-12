<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function leads()
    {
        return view('agent.leads');
    }

    public function calls()
    {
        return view('agent.calls');
    }

    public function stats()
    {
        return view('agent.stats');
    }
}