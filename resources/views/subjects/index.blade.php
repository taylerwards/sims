@extends('layouts.sims', ['title' => 'Subjects'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Records</p>
            <h1>Subjects</h1>
            <p class="muted" style="margin-bottom:0">Manage subjects available for student enrollment.</p>
        </div>
        <a class="button" href="{{ route('subjects.create') }}">Add subject</a>
    </div>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif

    <section class="table-card" aria-label="Subject records">
        @if ($subjects->isEmpty())
            <div class="empty-state" style="border:0">
                <div><div class="empty-icon" aria-hidden="true">S</div><h2>No subjects yet</h2><p>Add a subject before enrolling students.</p></div>
            </div>
        @else
            <table>
                <thead><tr><th>Subject Code</th><th>Subject Name</th><th>Description</th><th>Units</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->subject_code }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->description ?: '—' }}</td>
                        <td>{{ $subject->units }}</td>
                        <td><div class="actions">
                            <a href="{{ route('subjects.show', $subject) }}">View</a>
                            <a href="{{ route('subjects.edit', $subject) }}">Edit</a>
                            <form class="inline-form" method="POST" action="{{ route('subjects.destroy', $subject) }}" onsubmit="return confirm('Delete this subject? Enrollments for this subject will also be deleted.')">
                                @csrf @method('DELETE')
                                <button class="danger-link" type="submit">Delete</button>
                            </form>
                        </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{ $subjects->links() }}</div>
        @endif
    </section>
</main>
@endsection
