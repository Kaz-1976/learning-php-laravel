<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'ユーザーID',
            'user_name' => '氏名（漢字）',
            'user_kana' => '氏名（かな）',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'cart_id' => 'カートID'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'max:255', 'unique:ec_users,user_id,' . $this->user_id . ',user_id'],
            'user_name' => ['required', 'string', 'max:255'],
            'user_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:ec_users,email,' . $this->email . ',email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^[a-zA-Z0-9!@#$%^&*_]+$/'],
        ];
    }
}
