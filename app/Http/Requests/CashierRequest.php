<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('userId');

        return [
            'name' => $this->isMethod('POST') ? 'required|string|max:255' : 'sometimes|string|max:255',
            'email' => $this->isMethod('POST')
                ? 'required|email|unique:users,email'
                : 'sometimes|email|unique:users,email,' . $userId,
            'password' => $this->isMethod('POST') ? 'required|string|min:8' : 'sometimes|string|min:8',
        ];
    }
}
