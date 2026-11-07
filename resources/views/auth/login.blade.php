@extends('layouts.sims', ['title' => 'Log in'])

@section('content')
<main class="auth-card">
    <p class="eyebrow">Welcome back</p>
    <h1>Log in to SIMS</h1>
    <p class="muted">Enter your account details to continue to the dashboard.</p>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autofocus autocomplete="username">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required maxlength="255" autocomplete="current-password">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <label style="display:flex;align-items:center;gap:8px;margin:18px 0;font-weight:500">
            <input style="width:16px;height:16px" type="checkbox" name="remember" value="1">
            Remember me
        </label>

        <button class="button full" type="submit">Log in</button>
    </form>

    <p class="auth-footer">Need an account? <a href="{{ route('register') }}">Register here</a></p>
</main>
@endsection
