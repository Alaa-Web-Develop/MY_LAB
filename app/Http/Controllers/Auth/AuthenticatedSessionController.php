<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
         return view('auth.login');
       //return view('myAuthViews.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        
        //Check all guards

        // if(! Auth::guard('admin')->attempt($request->only('email', 'password'), $request->boolean('remember')))
        // {
        //     throw ValidationException::withMessages([
        //         'email' => trans('auth.failed'),
        //     ]);
        // }

        $request->session()->regenerate();

        // if (Auth::guard('admin')->check()) {
        //     return redirect()->route('admin.dashboard');
        // } elseif (Auth::guard('web')->check()) {
        //     return redirect()->route('user.dashboard');
        // }

        //Redirect based on user type

        //return redirect()->route('dashboard');
       
      
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');

    }
}
