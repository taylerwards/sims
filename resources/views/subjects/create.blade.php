@extends('layouts.sims', ['title' => 'Add Subject'])

@section('content')
<main class="main">
    <div class="page-heading"><div><p class="eyebrow">Subject records</p><h1>Add subject</h1><p class="muted" style="margin-bottom:0">Enter the subject information below.</p></div></div>
    @include('subjects.form', ['action' => route('subjects.store'), 'method' => 'POST', 'subject' => null, 'buttonText' => 'Save subject'])
</main>
@endsection
