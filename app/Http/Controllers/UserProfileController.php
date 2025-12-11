<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    
    public function index(Request $request)
    {
        $query = User::query();

       
        $query->where('is_admin', false);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('username')->paginate(10)->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
