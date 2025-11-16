<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify');
    }

    // ワンクリック認証
    public function autoVerify(Request $request)
    {
        $user = $request->user();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified(); // メール認証完了
        }

        return redirect()->route('mypage.edit')->with('status', 'メール認証が完了しました');
    }

    // 認証メール再送信（任意）
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', '認証メールを再送しました');
    }
}
