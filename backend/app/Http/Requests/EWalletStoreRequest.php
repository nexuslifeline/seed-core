<?php

namespace App\Http\Requests;


class EWalletStoreRequest extends BaseFormRequest
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
        if ($this->has('validate') && !$this->input('validate')) {
            return [];
        }

        return [
            'name' => 'required|string|max:255',
        ];
    }
}
