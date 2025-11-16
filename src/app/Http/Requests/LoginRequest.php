<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }

    // 追加認証チェック
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $credentials = $this->only('email', 'password');
            $user = auth()->guard('web')->getProvider()->retrieveByCredentials($credentials);

            if (!$user || !auth()->guard('web')->getProvider()->validateCredentials($user, $credentials)) {
                $validator->errors()->add('email', 'ログイン情報が登録されていません');
            }
        });
    }
}
