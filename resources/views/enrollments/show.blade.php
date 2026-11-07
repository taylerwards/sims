@extends('layouts.sims', ['title' => 'Enrollment Details'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Enrollment record</p>
            <h1>Enrollment #{{ $enrollment->id }}</h1>
            <p class="muted" style="margin-bottom:0">Details for {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}.</p>
        </div>
        <div class="actions">
            <a class="secondary-button" href="{{ route('enrollments.index') }}">Back to enrollments</a>
            <a class="button" href="{{ route('enrollments.edit', $enrollment) }}">Update enrollment</a>
        </div>
    </div>

    <section class="form-card" aria-label="Enrollment details">
        <dl class="form-grid">
            <div class="field"><dt>Student</dt><dd>{{ $enrollment->student->student_number }} — {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</dd></div>
            <div class="field"><dt>Subject</dt><dd>{{ $enrollment->subject->subject_code }} — {{ $enrollment->subject->name }}</dd></div>
            <div class="field"><dt>Enrollment date</dt><dd>{{ $enrollment->enrollment_date->format('M j, Y') }}</dd></div>
            <div class="field"><dt>Status</dt><dd>{{ ucfirst($enrollment->status) }}</dd></div>
            <div class="field"><dt>Year level</dt><dd>{{ $enrollment->year_level }}</dd></div>
        </dl>
    </section>
</main>
@endsection
