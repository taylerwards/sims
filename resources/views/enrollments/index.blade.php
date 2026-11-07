@extends('layouts.sims', ['title' => 'Enrollments'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Records</p>
            <h1>Enrollments</h1>
            <p class="muted" style="margin-bottom:0">View and manage student subject enrollments.</p>
        </div>
        <a class="button" href="{{ route('enrollments.create') }}">Enroll student</a>
    </div>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif

    <section class="table-card" aria-label="Enrollment records">
        @if ($enrollments->isEmpty())
            <div class="empty-state" style="border:0">
                <div><div class="empty-icon" aria-hidden="true">E</div><h2>No enrollments yet</h2><p>Enroll a student in a subject to get started.</p></div>
            </div>
        @else
            <table>
                <thead><tr><th>Student</th><th>Subject</th><th>Enrollment date</th><th>Status</th><th>Year level</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->student->student_number }} — {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                        <td>{{ $enrollment->subject->subject_code }} — {{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->enrollment_date->format('M j, Y') }}</td>
                        <td>{{ ucfirst($enrollment->status) }}</td>
                        <td>{{ $enrollment->year_level }}</td>
                        <td><div class="actions">
                            <a href="{{ route('enrollments.show', $enrollment) }}">View</a>
                            <a href="{{ route('enrollments.edit', $enrollment) }}">Update</a>
                            <form class="inline-form" method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" onsubmit="return confirm('Delete this enrollment?')">
                                @csrf @method('DELETE')
                                <button class="danger-link" type="submit">Delete</button>
                            </form>
                        </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{ $enrollments->links() }}</div>
        @endif
    </section>
</main>
@endsection
