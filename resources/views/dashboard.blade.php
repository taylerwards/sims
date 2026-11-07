@extends('layouts.sims', ['title' => 'Dashboard'])

@section('content')
@php($yearLevelLabels = [1 => 'First Year', 2 => 'Second Year', 3 => 'Third Year', 4 => 'Fourth Year'])
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Overview</p>
            <h1>Dashboard</h1>
            <p class="muted" style="margin-bottom:0">Welcome, {{ auth()->user()->name }}. Here is your current record summary.</p>
        </div>
    </div>

    <section aria-labelledby="system-summary-heading">
        <div class="chart-heading" style="margin-bottom:16px"><h2 id="system-summary-heading">System Summary</h2><p class="chart-note">Current totals across the system.</p></div>
        <div class="summary-grid" aria-label="Current record totals">
        <article class="summary-card">
            <p class="eyebrow">Students</p>
            <strong>{{ number_format($studentCount) }}</strong>
        </article>
        <article class="summary-card">
            <p class="eyebrow">Subjects</p>
            <strong>{{ number_format($subjectCount) }}</strong>
        </article>
        <article class="summary-card">
            <p class="eyebrow">Enrollments</p>
            <strong>{{ number_format($enrollmentCount) }}</strong>
        </article>
        </div>
    </section>

    <section class="dashboard-chart-card" aria-labelledby="student-statistics-heading" style="margin-bottom:22px">
        <div class="chart-heading"><div><p class="eyebrow">Student Statistics</p><h2 id="student-statistics-heading">Students by year level</h2></div></div>
        <div class="summary-grid" style="margin:20px 0 0">
            @foreach (range(1, 4) as $level)
                <article class="summary-card"><p class="eyebrow">{{ $yearLevelLabels[$level] }}</p><strong>{{ number_format((int) ($studentYearLevelCounts->get($level) ?? 0)) }}</strong></article>
            @endforeach
        </div>
    </section>

    <section class="dashboard-chart-card" aria-labelledby="enrollment-statistics-heading" style="margin-bottom:22px">
        <div class="chart-heading"><div><p class="eyebrow">Enrollment Statistics</p><h2 id="enrollment-statistics-heading">Enrollments by status</h2></div></div>
        @if ($enrollmentStatusCounts->isEmpty())
            <div class="chart-empty" role="status"><p>No enrollment records to summarize yet.</p></div>
        @else
            <div class="summary-grid" style="margin:20px 0 0">
                @foreach ($enrollmentStatusCounts as $statusCount)
                    <article class="summary-card"><p class="eyebrow">{{ ucfirst($statusCount->status) }}</p><strong>{{ number_format((int) $statusCount->total) }}</strong></article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="dashboard-chart-card" aria-labelledby="enrollment-chart-heading">
        <div class="chart-heading">
            <div>
                <p class="eyebrow">Enrollment trends</p>
                <h2 id="enrollment-chart-heading">Enrollments by year and year level</h2>
            </div>
            <p class="chart-note">Year is based on the enrollment date.</p>
        </div>

        @if ($enrollmentChart->isEmpty())
            <div class="chart-empty" role="status">
                <p>No enrollment records to chart yet.</p>
            </div>
        @else
            <div class="chart-legend" aria-label="Year level legend">
                @foreach (range(1, 4) as $level)
                    <span class="legend-item"><i class="legend-swatch level-{{ $level }}"></i>{{ $yearLevelLabels[$level] }}</span>
                @endforeach
            </div>

            <figure class="vertical-chart-figure" aria-label="Vertical bar chart showing enrollment counts by calendar year, with separate bars for year levels one through four">
                <div class="vertical-chart-scroll" tabindex="0" aria-label="Scroll chart horizontally to view all years">
                    <div class="vertical-chart" style="min-width: {{ max(560, $enrollmentChart->count() * 112) }}px">
                        <div class="chart-y-axis" aria-hidden="true">
                            <span>{{ number_format($chartMax) }}</span>
                            <span>0</span>
                        </div>
                        <div class="chart-plot">
                            @foreach ($enrollmentChart as $yearData)
                                <div class="chart-year-group">
                                    <div class="chart-year-bars">
                                        @foreach ($yearData['levels'] as $levelData)
                                            <div class="chart-level-column">
                                                <span class="chart-bar-value">{{ $levelData['count'] }}</span>
                                                <div class="vertical-bar level-{{ $levelData['level'] }}" style="height: {{ ($levelData['count'] / $chartMax) * 100 }}%" title="{{ $yearLevelLabels[$levelData['level']] }}: {{ $levelData['count'] }} enrollments"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="chart-year-label">{{ $yearData['year'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <figcaption class="chart-caption">Each vertical bar shows enrollment records for a calendar year and college year level.</figcaption>
            </figure>
        @endif
    </section>
</main>
@endsection
