<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcAddressRequest extends FormRequest
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
            'name' => '配送先名',
            'zip' => '郵便番号',
            'pref' => '都道府県',
            'address1' => '住所１',
            'address2' => '住所２',
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
            'name' => 'required|max:255',
            'zip' => 'required|digits:7|exists:ec_zips,code',
            'pref' => 'required|max:2|exists:ec_prefs,code',
            'address1' => 'required|max:255',
            'address2' => 'max:255',
        ];
    }
}
