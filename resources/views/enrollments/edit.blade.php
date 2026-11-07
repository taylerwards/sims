@extends('layouts.sims', ['title' => 'Update Enrollment'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Enrollment records</p><h1>Update enrollment</h1><p class="muted" style="margin-bottom:0">Change the student, subject, date, status, or year level.</p></div></div>
    @include('enrollments.form', ['action' => route('enrollments.update', $enrollment), 'method' => 'PUT', 'enrollment' => $enrollment, 'buttonText' => 'Save changes'])
</main>
@endsection
