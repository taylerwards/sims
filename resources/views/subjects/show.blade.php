@extends('layouts.sims', ['title' => 'Subject details'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div><p class="eyebrow">Subject records</p><h1>Subject details</h1><p class="muted" style="margin-bottom:0">{{ $subject->subject_code }} · {{ $subject->name }}</p></div>
        <div class="actions">
            <a class="secondary-button" href="{{ route('subjects.index') }}">Back to subjects</a>
            <a class="button" href="{{ route('subjects.edit', $subject) }}">Edit subject</a>
        </div>
    </div>
    <section class="form-card" aria-label="Subject information">
        <dl class="form-grid">
            <div class="field"><dt>Subject Code</dt><dd>{{ $subject->subject_code }}</dd></div>
            <div class="field"><dt>Subject Name</dt><dd>{{ $subject->name }}</dd></div>
            <div class="field"><dt>Units</dt><dd>{{ $subject->units }}</dd></div>
            <div class="field"><dt>Description</dt><dd>{{ $subject->description ?: '—' }}</dd></div>
        </dl>
    </section>
</main>
@endsection
