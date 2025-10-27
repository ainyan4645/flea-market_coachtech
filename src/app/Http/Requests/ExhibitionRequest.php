<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image_path' => ['required', 'file', 'mimes:jpg,jpeg,png'],
            'categories' => ['required', 'array', 'min:1'],
            'condition' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => '商品画像を選択してください。',
            'image_path.mimes' => '画像はjpg、jpeg、png形式のみアップロードできます。',
            'categories.required' => 'カテゴリーを1つ以上選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'price.required' => '販売価格を入力してください。',
            'price.numeric' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は0円以上にしてください。',
        ];
    }
}
