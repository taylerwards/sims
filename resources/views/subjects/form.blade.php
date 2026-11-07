<form class="form-card" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="field">
        <label for="subject_code">Subject Code</label>
        <input id="subject_code" name="subject_code" value="{{ old('subject_code', $subject?->subject_code) }}" maxlength="255" required autofocus>
        @error('subject_code') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="name">Subject Name</label>
        <input id="name" name="name" value="{{ old('name', $subject?->name) }}" maxlength="255" required>
        @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="description">Description <span style="font-weight:400;color:#6b7890">(optional)</span></label>
        <textarea id="description" name="description" rows="4" maxlength="10000">{{ old('description', $subject?->description) }}</textarea>
        @error('description') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="units">Units</label>
        <input id="units" name="units" type="number" min="1" max="255" value="{{ old('units', $subject?->units ?? 3) }}" required>
        @error('units') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="actions">
        <button class="button" type="submit">{{ $buttonText }}</button>
        <a class="secondary-button" href="{{ route('subjects.index') }}">Cancel</a>
    </div>
</form>
