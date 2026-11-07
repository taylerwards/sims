@extends('layouts.sims', ['title' => 'Student Details'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Student record</p>
            <h1>{{ $student->first_name }} {{ $student->last_name }}</h1>
            <p class="muted" style="margin-bottom:0">Student number: {{ $student->student_number }}</p>
        </div>
        <div class="actions">
            <a class="secondary-button" href="{{ route('students.index') }}">Back to students</a>
            <a class="button" href="{{ route('students.edit', $student) }}">Edit student</a>
        </div>
    </div>

    <section class="form-card" aria-label="Student details">
        <dl class="form-grid">
            <div class="field"><dt>First name</dt><dd>{{ $student->first_name }}</dd></div>
            <div class="field"><dt>Last name</dt><dd>{{ $student->last_name }}</dd></div>
            <div class="field"><dt>Student number</dt><dd>{{ $student->student_number }}</dd></div>
            <div class="field"><dt>Email</dt><dd>{{ $student->email }}</dd></div>
            <div class="field"><dt>Course</dt><dd>{{ $student->course }}</dd></div>
            <div class="field"><dt>Year level</dt><dd>{{ $student->year_level }}</dd></div>
        </dl>
    </section>
</main>
@endsection
