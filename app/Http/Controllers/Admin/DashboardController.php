<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Permit;
use App\Models\TeamMember;
use App\Models\TourGuide;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with Analytics.
     */
    public function index()
    {
        // 1. Resource Counts (Total System Resources)
     
        // 1. Resource Counts (Active System Resources)
$counts = [
           'users'   => \App\Models\User::count(),
    'guides'  => \App\Models\TourGuide::where('is_active', '1')->count(),
    'areas'   => \App\Models\Area::where('is_active', '1')->count(),

];


        // 2. Headcount Analytics (Based on Individual Team Members)
        $permitStats = [
            'total_permits' => Permit::count(),

            // Count individuals whose permit is currently 'active'
            // Count individuals currently inside (Permit status is 'arrived')
            'inside' => TeamMember::whereHas('permit', function ($query) {
                $query->where('status', 'arrived');
            })->count(),

            // Count individuals who have left (Permit status is 'exited')
            'exited' => TeamMember::whereHas('permit', function ($query) {
                $query->where('status', 'exited');
            })->count(),

            // Optional: Count individuals expected to arrive
            'pending_arrival' => TeamMember::whereHas('permit', function ($query) {
                $query->where('status', 'to arrive');
            })->count(),

            // Count groups (permits) expected to arrive today
            'expected_today' => Permit::whereDate('arrival_datetime', Carbon::today())->count(),
        ];

        // 3. Visitor Metrics
        $totalVisitors = TeamMember::count();

        // Total headcount of individuals expected to arrive today
        $visitorsExpectedToday = TeamMember::whereHas('permit', function ($query) {
            $query->whereDate('arrival_datetime', Carbon::today());
        })->count();

        // 4. Financial Analytics
        // Lifetime Revenue
        $totalRevenue = Permit::sum('amount');

        // Revenue collected specifically today
        $todayRevenue = Permit::whereDate('created_at', Carbon::today())->sum('amount');

        // 5. Monthly Revenue Trend (Last 6 months)
        $monthlyRevenue = Permit::select(
            DB::raw('SUM(amount) as revenue'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'), 'ASC')
            ->get();

        // 6. Recent Activity (Latest 5 applications)
        // $recentPermits = Permit::with(['tourGuide', 'area'])
        // ->latest()
        // ->take(5)
        //  ->get();

        // 7. Pass all data to the Admin Dashboard view
        return view('admin.dashboard', compact(
            'counts',
            'permitStats',
            'totalVisitors',
            'visitorsExpectedToday',
            'totalRevenue',
            'todayRevenue',
            'monthlyRevenue',
            // 'recentPermits'
        ));
    }
}
