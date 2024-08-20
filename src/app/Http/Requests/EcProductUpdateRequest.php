<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcProductUpdateRequest extends FormRequest
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
            'product_name' => '商品名',
            'qty' => '数量',
            'price' => '価格',
            'image' => '画像',
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
            'product_name' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:1'],
            'image' => ['image', 'max:1024']
        ];
    }
}
