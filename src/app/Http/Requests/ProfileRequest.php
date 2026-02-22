<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'icon' => 'nullable|file|mimes:jpeg,png|max:2048', // プロフィール画像
            'name' => 'required|string|max:20',               // ユーザー名
            'postcode' => [
                'required',
                'regex:/^\d{3}-\d{4}$/',                      // 例：123-4567
            ],
            'address' => 'required|string|max:255',           // 住所
            'building' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'icon.mimes' => 'プロフィール画像はjpegまたはpng形式でアップロードしてください。',
            'name.required' => 'ユーザー名を入力してください。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',
            'postcode.required' => '郵便番号を入力してください。',
            'postcode.regex' => '郵便番号はハイフンありの8文字で入力してください（例：123-4567）。',
            'address.required' => '住所を入力してください。',
        ];
    }
}
