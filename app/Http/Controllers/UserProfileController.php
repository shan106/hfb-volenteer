<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Publiek overzicht van vrijwilligers, met zoekfunctie op
     * gebruikersnaam, naam en de 'over mij' tekst.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q'));

        $users = User::query()
            ->where('is_admin', false)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('about', 'like', "%{$search}%");
                });
            })
            ->orderBy('username')
            ->paginate(12)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    /**
     * Publieke profielpagina van één vrijwilliger.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}