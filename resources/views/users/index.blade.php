@extends('layouts.sims', ['title' => 'Users'])

@section('content')
<main class="main">
    <div class="page-heading">
        <div>
            <p class="eyebrow">Administration</p>
            <h1>Users</h1>
            <p class="muted" style="margin-bottom:0">Review registered accounts and assign their system role.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->has('user'))
        <div class="alert" role="alert">{{ $errors->first('user') }}</div>
    @endif

    <section class="table-card" aria-label="Registered users">
        @if ($users->isEmpty())
            <div class="empty-state" style="border:0">
                <div><div class="empty-icon" aria-hidden="true">U</div><h2>No users found</h2><p>Registered accounts will appear here.</p></div>
            </div>
        @else
            <table>
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Registered</th><th>Update role</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at?->format('M j, Y') }}</td>
                        <td>
                            <form class="actions" method="POST" action="{{ route('users.role.update', $user) }}">
                                @csrf @method('PUT')
                                <input type="hidden" name="_role_user" value="{{ $user->id }}">
                                <label class="sr-only" for="role-{{ $user->id }}">Role for {{ $user->name }}</label>
                                <select id="role-{{ $user->id }}" name="role" style="width:auto;min-width:145px" aria-label="Role for {{ $user->name }}">
                                    <option value="staff" @selected(old('role', $user->role) === 'staff')>Staff</option>
                                    <option value="administrator" @selected(old('role', $user->role) === 'administrator')>Administrator</option>
                                </select>
                                <button class="text-button" type="submit">Save</button>
                            </form>
                            @if ($errors->has('role') && old('_role_user') == $user->id)
                                <p class="error">{{ $errors->first('role') }}</p>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('users.show', $user) }}">Update</a>
                                @if (!auth()->user()->is($user))
                                    <form class="inline-form" method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button class="danger-link" type="submit">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{ $users->links() }}</div>
        @endif
    </section>
</main>
@endsection

