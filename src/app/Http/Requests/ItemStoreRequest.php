<?php

namespace App\Http\Requests;

use App\Models\EcProduct;
use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'order' => '注文数量',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 商品レコード取得
        $ec_product = EcProduct::find($this->id);

        return [
            'order' => ['required', 'integer', 'min:1', 'max:' . $ec_product->qty],
        ];
    }
}
