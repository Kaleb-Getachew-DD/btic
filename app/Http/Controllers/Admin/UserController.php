<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function ensureSuperAdmin(): void
    {
        if (!auth()->user()?->isSuperAdmin()) {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureSuperAdmin();

        $query = User::query()->orderByDesc('id');

        if (request('search')) {
            $search = trim((string) request('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (request('role')) {
            $query->where('role', request('role'));
        }

        $users = $query->paginate(15)->withQueryString();

        $deletedUsers = User::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(10, ['*'], 'deleted_page')
            ->withQueryString();

        return view('admin.users.index', compact('users', 'deletedUsers'));
    }

    public function create()
    {
        $this->ensureSuperAdmin();

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->ensureSuperAdmin();

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
            'is_active' => (bool) $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->ensureSuperAdmin();

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->ensureSuperAdmin();

        $data = $request->only('name', 'email', 'role');
        $data['is_active'] = (bool) $request->boolean('is_active', true);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->ensureSuperAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function restore(int $user)
    {
        $this->ensureSuperAdmin();

        $deletedUser = User::onlyTrashed()->findOrFail($user);
        $deletedUser->restore();

        return back()->with('success', 'User restored successfully.');
    }
}

