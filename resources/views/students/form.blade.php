<form class="form-card" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="form-grid">
        <div class="field"><label for="student_number">Student number</label><input id="student_number" name="student_number" value="{{ old('student_number', $student?->student_number) }}" required maxlength="255" autocomplete="off">@error('student_number')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="field"><label for="email">Email</label><input id="email" type="email" name="email" value="{{ old('email', $student?->email) }}" required maxlength="255" autocomplete="email">@error('email')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="field"><label for="first_name">First name</label><input id="first_name" name="first_name" value="{{ old('first_name', $student?->first_name) }}" required maxlength="255" autocomplete="given-name">@error('first_name')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="field"><label for="last_name">Last name</label><input id="last_name" name="last_name" value="{{ old('last_name', $student?->last_name) }}" required maxlength="255" autocomplete="family-name">@error('last_name')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="field"><label for="course">Course</label><input id="course" name="course" value="{{ old('course', $student?->course) }}" required maxlength="255">@error('course')<p class="error">{{ $message }}</p>@enderror</div>
        <div class="field"><label for="year_level">Year level</label><input id="year_level" type="number" name="year_level" value="{{ old('year_level', $student?->year_level) }}" required min="1" max="4">@error('year_level')<p class="error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="actions" style="margin-top:10px"><button class="button" type="submit">{{ $buttonText }}</button><a class="secondary-button" href="{{ route('students.index') }}">Cancel</a></div>
</form>
