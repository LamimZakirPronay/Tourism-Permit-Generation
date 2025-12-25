<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TourGuide;
use App\Models\Driver;
use App\Models\Permit;
use App\Models\TeamMember;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Existing Resource Counts
        $counts = [
            'users'   => User::count(),
            'guides'  => TourGuide::count(),
            'drivers' => Driver::count(),
        ];

        // 2. Permit & Safety Analytics
        $permitStats = [
            'total'     => Permit::count(),
            'inside'    => Permit::where('status', 'active')->count(),
            'exited'    => Permit::where('status', 'completed')->count(),
        ];

        // 3. Visitor Count (Total individual team members registered)
        $totalVisitors = TeamMember::count();

        // 4. Financial Analytics (Using 'amount' from your Permit model)
        $totalRevenue = Permit::sum('amount');

        // 5. Monthly Revenue Trend (Last 6 months)
        $monthlyRevenue = Permit::select(
                DB::raw('SUM(amount) as revenue'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month', 'created_at')
            ->orderBy('created_at', 'ASC')
            ->get();

        return view('Admin.dashboard', compact(
            'counts', 
            'permitStats', 
            'totalVisitors', 
            'totalRevenue', 
            'monthlyRevenue'
        ));
    }
}