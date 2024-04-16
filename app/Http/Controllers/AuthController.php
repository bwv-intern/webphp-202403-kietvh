<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Libs\ConfigUtil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Render login page
     */
    public function login()
    {
        return view('screens.auth.login');
    }

    /**
     * Handle login
     */
    public function handleLogin(LoginRequest $request)
    {
        
    }

    /**
     * Logout the currently authenticated user.
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        session()->invalidate();
        return redirect()->route('login');
    }
}
