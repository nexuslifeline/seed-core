<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends BaseFormRequest
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
        return [
            'name' => 'required|string|max:255',
            'unit_id' => 'required',
            'category_id' => 'required',
        ];
    }

    /**
     * Returns an array of attributes for the PHP function.
     *
     * @return array An array of attributes.
     */
    public function attributes(): array
    {
        return [
            'unit_id' => 'unit',
            'category_id' => 'category',
        ];
    }
}
