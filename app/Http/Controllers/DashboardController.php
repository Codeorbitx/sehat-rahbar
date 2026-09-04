<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Referral;
use App\Models\Screening;
use App\Models\TriageResult;

class DashboardController extends Controller
{
    public function summary()
    {
        $totalPatients = Patient::count();
        $totalScreenings = Screening::count();
        $todaysScreenings = Screening::whereDate('created_at', today())->count();

        $priorityCounts = TriageResult::query()
            ->selectRaw('priority_level, COUNT(*) as total')
            ->groupBy('priority_level')
            ->pluck('total', 'priority_level');

        $referredCount = Referral::count();

        $highPriorityCases = TriageResult::with(['screening.patient', 'referrals'])
            ->where('priority_level', 'high')
            ->latest()
            ->limit(10)
            ->get();

        $recentScreenings = Screening::with('patient', 'triageResult')
            ->latest()
            ->limit(5)
            ->get();

        $recentPatients = Patient::latest()->limit(5)->get();

        return view('dashboard.summary', [
            'totalPatients' => $totalPatients,
            'totalScreenings' => $totalScreenings,
            'todaysScreenings' => $todaysScreenings,
            'highCount' => $priorityCounts->get('high', 0),
            'moderateCount' => $priorityCounts->get('moderate', 0),
            'lowCount' => $priorityCounts->get('low', 0),
            'referredCount' => $referredCount,
            'highPriorityCases' => $highPriorityCases,
            'recentScreenings' => $recentScreenings,
            'recentPatients' => $recentPatients,
        ]);
    }
}
