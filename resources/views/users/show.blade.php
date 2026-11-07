@extends('layouts.sims', ['title' => 'User details'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Administration</p>
            <h1>User details</h1>
            <p class="muted" style="margin-bottom:0">View account information and set a new password.</p>
        </div>
        <a class="secondary-button" href="{{ route('users.index') }}">Back to users</a>
    </div>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->has('user'))
        <div class="alert" role="alert">{{ $errors->first('user') }}</div>
    @endif

    <section class="form-card" aria-label="User information">
        <dl class="form-grid">
            <div class="field"><dt>Name</dt><dd>{{ $user->name }}</dd></div>
            <div class="field"><dt>Email</dt><dd>{{ $user->email }}</dd></div>
            <div class="field"><dt>Role</dt><dd>{{ ucfirst($user->role) }}</dd></div>
            <div class="field"><dt>Registered</dt><dd>{{ $user->created_at?->format('M j, Y') }}</dd></div>
        </dl>
    </section>

    <section class="form-card" style="margin-top:22px" aria-label="Update user password">
        <h2 style="margin:0 0 8px;font-size:19px">Update password</h2>
        <p class="muted">Set a new password for {{ $user->name }}. The user will need the new password to sign in.</p>
        <form method="POST" action="{{ route('users.password.update', $user) }}">
            @csrf @method('PUT')
            <div class="field">
                <label for="password">New password</label>
                <input id="password" name="password" type="password" required minlength="8" maxlength="255" autocomplete="new-password">
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" maxlength="255" autocomplete="new-password">
            </div>
            <button class="button" type="submit">Update password</button>
        </form>
    </section>
</main>
@endsection
