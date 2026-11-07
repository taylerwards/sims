@extends('layouts.sims', ['title' => 'Students'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Records</p>
            <h1>Students</h1>
            <p class="muted" style="margin-bottom:0">Manage student records and contact details.</p>
        </div>
        <a class="button" href="{{ route('students.create') }}">Add student</a>
    </div>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif

    <form class="toolbar" method="GET" action="{{ route('students.index') }}" style="margin-bottom:16px">
        <input type="search" name="search" value="{{ request('search') }}" maxlength="255" placeholder="Search students" aria-label="Search students">
        <button class="button" type="submit">Search</button>
        @if (request('search')) <a class="secondary-button" href="{{ route('students.index') }}">Clear</a> @endif
    </form>

    <section class="table-card" aria-label="Student records">
        @if ($students->isEmpty())
            <div class="empty-state" style="border:0">
                <div><div class="empty-icon" aria-hidden="true">S</div><h2>No students found</h2><p>Add a student to get started, or try a different search.</p></div>
            </div>
        @else
            <table>
                <thead><tr><th>Student number</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_number }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td><div class="actions">
                            <a href="{{ route('students.show', $student) }}">View</a>
                            <a href="{{ route('students.edit', $student) }}">Edit</a>
                            <form class="inline-form" method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student record? Enrollments for this student will also be deleted.')">
                                @csrf @method('DELETE')
                                <button class="danger-link" type="submit">Delete</button>
                            </form>
                        </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{ $students->links() }}</div>
        @endif
    </section>
</main>
@endsection
