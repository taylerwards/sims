@extends('layouts.sims', ['title' => 'Enroll Student'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Enrollment records</p><h1>Enroll student</h1><p class="muted" style="margin-bottom:0">Choose a student and subject to create an enrollment.</p></div></div>
    @include('enrollments.form', ['action' => route('enrollments.store'), 'method' => 'POST', 'enrollment' => null, 'buttonText' => 'Save enrollment'])
</main>
@endsection
