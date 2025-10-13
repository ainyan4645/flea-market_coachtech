<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;
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
        // 1. フォームリクエストでバリデーション
        $validated = $request->validated();

        // 2. Fortifyの認証機能を使う
        $user = Auth::guard('web')->getProvider()->retrieveByCredentials($validated);

        if ($user && Auth::guard('web')->getProvider()->validateCredentials($user, $validated)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => ['ログイン情報が登録されていません'],
        ]);
    }
}
