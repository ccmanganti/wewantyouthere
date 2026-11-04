<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class WeddingAuthController extends Controller
{
    public function registration(): View|RedirectResponse
    {
        return redirect('/app/register');
    }

    public function loginForm(): View|RedirectResponse
    {
        return redirect('/app/login');
    }

    public function register(Request $request): RedirectResponse
    {
        abort_if(Auth::check(), 403);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create($data);
        if (Role::where('name', 'User')->where('guard_name', 'web')->exists()) {
            $user->assignRole('User');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return $request->session()->has('pending_wedding')
            ? app(WeddingBuilderController::class)->complete($request)
            : redirect()->route('home');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'These credentials do not match our records.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return $request->session()->has('pending_wedding')
            ? app(WeddingBuilderController::class)->complete($request)
            : redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
