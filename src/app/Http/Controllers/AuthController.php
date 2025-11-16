<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register() {
        return view('auth.register');
    }

    public function login() {
        return view('auth.login');
    }

    public function store(RegisterRequest $request)
    {
        // フォームリクエストでバリデーション
        $validated = $request->validated();

        // CreateNewUser を直接呼び出してユーザー作成
        $creator = new CreateNewUser();
        $user = $creator->create($validated);

        // ログイン
        Auth::login($user);

        return redirect('/mypage/profile');
    }

    public function loginValid(LoginRequest $request)
    {
        // バリデーション & 認証チェックは LoginRequest 内で完結
        $credentials = $request->only('email', 'password');
        $user = Auth::guard('web')->getProvider()->retrieveByCredentials($credentials);

        if ($user) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
    }
}
