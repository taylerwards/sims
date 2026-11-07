@extends('layouts.sims', ['title' => 'Create account'])

@section('content')
<main class="auth-card">
    <p class="eyebrow">Get started</p>
    <h1>Create your account</h1>
    <p class="muted">Register to access the Student Information Management System.</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="field">
            <label for="name">Full name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" autofocus autocomplete="name">
            @error('name') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required minlength="8" maxlength="255" autocomplete="new-password">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" maxlength="255" autocomplete="new-password">
        </div>

        <button class="button full" type="submit">Create account</button>
    </form>

    <p class="auth-footer">Already registered? <a href="{{ route('login') }}">Log in</a></p>
</main>
@endsection
