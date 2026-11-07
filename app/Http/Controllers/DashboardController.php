<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $yearExpression = match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y', enrollment_date)",
            'pgsql' => 'EXTRACT(YEAR FROM enrollment_date)',
            default => 'YEAR(enrollment_date)',
        };

        $yearLevelCounts = Enrollment::query()
            ->selectRaw("{$yearExpression} as calendar_year, year_level, COUNT(*) as total")
            ->groupByRaw("{$yearExpression}, year_level")
            ->orderBy('calendar_year')
            ->get()
            ->keyBy(fn ($row) => (string) $row->calendar_year.'-'.$row->year_level);

        $years = $yearLevelCounts
            ->pluck('calendar_year')
            ->map(fn ($year) => (string) $year)
            ->unique()
            ->sort()
            ->values();

        $enrollmentChart = $years->map(fn ($year) => [
            'year' => $year,
            'levels' => collect(range(1, 4))->map(fn ($level) => [
                'level' => $level,
                'count' => (int) ($yearLevelCounts->get($year.'-'.$level)?->total ?? 0),
            ]),
        ]);

        $studentYearLevelCounts = Student::query()
            ->select('year_level', DB::raw('COUNT(*) as total'))
            ->groupBy('year_level')
            ->pluck('total', 'year_level');

        $enrollmentStatusCounts = Enrollment::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        return view('dashboard', [
            'studentCount' => Student::count(),
            'subjectCount' => Subject::count(),
            'enrollmentCount' => Enrollment::count(),
            'enrollmentChart' => $enrollmentChart,
            'chartMax' => max(1, (int) $yearLevelCounts->max('total')),
            'studentYearLevelCounts' => $studentYearLevelCounts,
            'enrollmentStatusCounts' => $enrollmentStatusCounts,
        ]);
    }
}
