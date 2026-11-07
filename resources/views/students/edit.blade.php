@extends('layouts.sims', ['title' => 'Edit Student'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Student records</p><h1>Edit student</h1><p class="muted" style="margin-bottom:0">Update {{ $student->first_name }} {{ $student->last_name }}'s information.</p></div></div>
    @include('students.form', ['action' => route('students.update', $student), 'method' => 'PUT', 'student' => $student, 'buttonText' => 'Save changes'])
</main>
@endsection
