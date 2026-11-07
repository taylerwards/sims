@extends('layouts.sims', ['title' => 'Edit Subject'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Subject records</p><h1>Edit subject</h1><p class="muted" style="margin-bottom:0">Update {{ $subject->name }}.</p></div></div>
    @include('subjects.form', ['action' => route('subjects.update', $subject), 'method' => 'PUT', 'subject' => $subject, 'buttonText' => 'Save changes'])
</main>
@endsection
