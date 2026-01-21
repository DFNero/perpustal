<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $query = User::query();
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%');
        }
        
        $users = $query->latest()
            ->with(['borrowings' => function ($query) {
                $query->whereIn('status', ['pending', 'approved']);
            }])
            ->paginate(50);
        
        return view('admin.users.index', compact('users', 'search'));
    }

    public function createStaff()
    {
        return view('admin.users.create-staff');
    }

    public function storeStaff(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'staff',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun staff berhasil dibuat.');
    }

    public function ban(Request $request, User $user)
    {
        $data = $request->validate([
            'duration' => 'required|in:1,7,30,permanent',
            'reason' => 'required|string|max:255',
        ]);

        // Prevent banning self
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'error' => 'Anda tidak bisa ban diri sendiri.',
            ]);
        }

        // Prevent banning admin
        if ($user->role === 'admin') {
            return back()->withErrors([
                'error' => 'Tidak bisa ban akun admin.',
            ]);
        }

        // Check if already banned
        if ($user->isBanned()) {
            $message = 'User sudah di-ban sebelumnya';
            if ($user->ban_until) {
                $message .= ' sampai ' . $user->ban_until->format('d M Y H:i');
            }
            if ($user->banned_reason) {
                $message .= ' karena: ' . $user->banned_reason;
            }
            return back()->withErrors([
                'error' => $message,
            ]);
        }

        $user->banUser($data['duration'], $data['reason']);

        return back()->with('success', 'User berhasil di-ban.');
    }

    public function unban(User $user)
    {
        $user->unbanUser();
        return back()->with('success', 'User berhasil di-unban.');
    }
}
