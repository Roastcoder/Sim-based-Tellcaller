<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Company, Lead, CallLog, AgentStat};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        return match($user->role_id) {
            User::SUPER_ADMIN => $this->superAdminDashboard(),
            User::ADMIN => $this->adminDashboard($user),
            User::MANAGER => $this->managerDashboard($user),
            User::AGENT => $this->agentDashboard($user),
            default => abort(403)
        };
    }

    private function superAdminDashboard()
    {
        $stats = [
            'total_companies' => Company::count(),
            'total_users' => User::count(),
            'total_leads' => Lead::count(),
            'total_calls_today' => CallLog::whereDate('start_time', today())->count(),
            'active_companies' => Company::where('status', true)->count(),
            'recent_companies' => Company::latest()->take(5)->get(),
        ];

        $monthlyStats = $this->getMonthlyStats();
        
        return view('dashboard.super-admin', compact('stats', 'monthlyStats'));
    }

    private function adminDashboard(User $user)
    {
        $companyId = $user->company_id;
        
        $stats = [
            'total_users' => User::where('company_id', $companyId)->count(),
            'total_leads' => Lead::where('company_id', $companyId)->count(),
            'total_teams' => $user->company->teams()->count(),
            'calls_today' => CallLog::whereHas('user', fn($q) => $q->where('company_id', $companyId))
                                   ->whereDate('start_time', today())->count(),
            'conversion_rate' => $this->getCompanyConversionRate($companyId),
            'recent_leads' => Lead::where('company_id', $companyId)->latest()->take(5)->get(),
            'top_agents' => $this->getTopAgents($companyId),
        ];

        $chartData = $this->getCompanyChartData($companyId);
        
        return view('dashboard.admin', compact('stats', 'chartData'));
    }

    private function managerDashboard(User $user)
    {
        $teamIds = $user->managedTeams()->pluck('id');
        
        $stats = [
            'team_agents' => User::whereIn('team_id', $teamIds)->count(),
            'team_leads' => Lead::whereIn('team_id', $teamIds)->count(),
            'calls_today' => CallLog::whereHas('user', fn($q) => $q->whereIn('team_id', $teamIds))
                                   ->whereDate('start_time', today())->count(),
            'team_conversion_rate' => $this->getTeamConversionRate($teamIds),
            'pending_assignments' => Lead::whereIn('team_id', $teamIds)
                                        ->whereNull('assigned_to')->count(),
            'recent_activities' => $this->getTeamActivities($teamIds),
            'agent_performance' => $this->getAgentPerformance($teamIds),
        ];

        return view('dashboard.manager', compact('stats'));
    }

    private function agentDashboard(User $user)
    {
        $today = today();
        
        $stats = [
            'my_leads' => $user->leads()->count(),
            'calls_today' => $user->callLogs()->whereDate('start_time', $today)->count(),
            'talk_time_today' => $user->callLogs()->whereDate('start_time', $today)
                                     ->sum('duration_seconds'),
            'conversions_this_month' => $user->leads()
                                            ->where('status', Lead::STATUS_CONVERTED)
                                            ->whereMonth('updated_at', now()->month)->count(),
            'follow_ups_due' => $user->leads()->needsFollowUp()->count(),
            'recent_calls' => $user->callLogs()->with('lead')->latest('start_time')->take(5)->get(),
            'lead_status_breakdown' => $this->getAgentLeadBreakdown($user->id),
        ];

        $weeklyStats = AgentStat::where('user_id', $user->id)
                                ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                                ->get();

        return view('dashboard.agent', compact('stats', 'weeklyStats'));
    }

    private function getMonthlyStats()
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'month' => $date->format('M Y'),
                'companies' => Company::whereMonth('created_at', $date->month)
                                     ->whereYear('created_at', $date->year)->count(),
                'users' => User::whereMonth('created_at', $date->month)
                              ->whereYear('created_at', $date->year)->count(),
            ]);
        }
        return $months;
    }

    private function getCompanyConversionRate($companyId)
    {
        $totalLeads = Lead::where('company_id', $companyId)->count();
        $convertedLeads = Lead::where('company_id', $companyId)
                             ->where('status', Lead::STATUS_CONVERTED)->count();
        
        return $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;
    }

    private function getTopAgents($companyId, $limit = 5)
    {
        return User::where('company_id', $companyId)
                   ->where('role_id', User::AGENT)
                   ->withCount(['leads as conversions' => fn($q) => $q->where('status', Lead::STATUS_CONVERTED)])
                   ->orderBy('conversions', 'desc')
                   ->take($limit)
                   ->get();
    }

    private function getCompanyChartData($companyId)
    {
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push([
                'date' => $date->format('M j'),
                'calls' => CallLog::whereHas('user', fn($q) => $q->where('company_id', $companyId))
                                 ->whereDate('start_time', $date)->count(),
                'leads' => Lead::where('company_id', $companyId)
                              ->whereDate('created_at', $date)->count(),
            ]);
        }
        return $days;
    }

    private function getTeamConversionRate($teamIds)
    {
        $totalLeads = Lead::whereIn('team_id', $teamIds)->count();
        $convertedLeads = Lead::whereIn('team_id', $teamIds)
                             ->where('status', Lead::STATUS_CONVERTED)->count();
        
        return $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;
    }

    private function getTeamActivities($teamIds)
    {
        return CallLog::whereHas('user', fn($q) => $q->whereIn('team_id', $teamIds))
                     ->with(['user', 'lead'])
                     ->latest('start_time')
                     ->take(10)
                     ->get();
    }

    private function getAgentPerformance($teamIds)
    {
        return User::whereIn('team_id', $teamIds)
                   ->where('role_id', User::AGENT)
                   ->with(['agentStats' => fn($q) => $q->whereDate('date', today())])
                   ->get()
                   ->map(function($agent) {
                       $todayStats = $agent->agentStats->first();
                       return [
                           'name' => $agent->name,
                           'calls' => $todayStats->total_calls ?? 0,
                           'talk_time' => $todayStats->total_talk_seconds ?? 0,
                           'conversions' => $todayStats->conversions ?? 0,
                       ];
                   });
    }

    private function getAgentLeadBreakdown($userId)
    {
        return Lead::where('assigned_to', $userId)
                   ->selectRaw('status, count(*) as count')
                   ->groupBy('status')
                   ->pluck('count', 'status')
                   ->toArray();
    }
}