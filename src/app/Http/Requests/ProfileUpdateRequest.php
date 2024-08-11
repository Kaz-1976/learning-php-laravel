<?php

namespace App\Http\Requests;

use App\Models\EcUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'max:255', Rule::unique(EcUser::class)->ignore($this->user()->user_id)],
            'user_name' => ['required', 'string', 'max:255'],
            'user_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(EcUser::class)->ignore($this->user()->email)],
        ];
    }
}
