@extends('layouts.sims', ['title' => 'Add Student'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Student records</p><h1>Add student</h1><p class="muted" style="margin-bottom:0">Enter the student's information below.</p></div></div>
    @include('students.form', ['action' => route('students.store'), 'method' => 'POST', 'student' => null, 'buttonText' => 'Save student'])
</main>
@endsection
