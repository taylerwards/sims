<form class="form-card" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="field">
        <label for="student_id">Student</label>
        <select id="student_id" name="student_id" required>
            <option value="">Choose a student</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" @selected(old('student_id', $enrollment?->student_id) == $student->id)>
                    {{ $student->student_number }} — {{ $student->first_name }} {{ $student->last_name }}
                </option>
            @endforeach
        </select>
        @error('student_id') <p class="error">{{ $message }}</p> @enderror
        @if ($students->isEmpty()) <p class="muted">Add a student before creating an enrollment.</p> @endif
    </div>

    <div class="field">
        <label for="subject_id">Subject</label>
        <select id="subject_id" name="subject_id" required>
            <option value="">Choose a subject</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" @selected(old('subject_id', $enrollment?->subject_id) == $subject->id)>
                    {{ $subject->subject_code }} — {{ $subject->name }}
                </option>
            @endforeach
        </select>
        @error('subject_id') <p class="error">{{ $message }}</p> @enderror
        @if ($subjects->isEmpty()) <p class="muted">Add a subject before creating an enrollment.</p> @endif
    </div>

    <div class="field">
        <label for="enrollment_date">Enrollment date</label>
        <input id="enrollment_date" name="enrollment_date" type="date" value="{{ old('enrollment_date', $enrollment?->enrollment_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
        @error('enrollment_date') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="status">Status</label>
        <input id="status" name="status" value="{{ old('status', $enrollment?->status ?? 'enrolled') }}" maxlength="255" required>
        @error('status') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="year_level">Year level</label>
        <input id="year_level" name="year_level" type="number" min="1" max="4" value="{{ old('year_level', $enrollment?->year_level) }}" required>
        @error('year_level') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="actions">
        <button class="button" type="submit" @disabled($students->isEmpty() || $subjects->isEmpty())>{{ $buttonText }}</button>
        <a class="secondary-button" href="{{ route('enrollments.index') }}">Cancel</a>
    </div>
</form>
