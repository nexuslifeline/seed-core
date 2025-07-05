<?php

namespace App\Http\Requests;

use App\Rules\SupplierBelongsToOrganization;
use Carbon\Carbon;

class PurchaseUpdateRequest extends BaseFormRequest
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
            // The 'supplier_id' field is required and must exist in the 'customers' table
            'supplier_id' => [
                'required',
                'exists:suppliers,id',
                new SupplierBelongsToOrganization($this->route('orgUuid')),
            ],
            // The 'purchase_date' field is required and must be a valid date
            'purchase_date' => 'required|date',
            // The 'total_amount' field is required, must be numeric, and must be greater than or equal to 0
            'total_amount' => 'required|numeric|min:0',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * This method is responsible for preparing the data that needs to be validated
     * before it is passed to the validation rules. It performs the following steps:
     * 1. It retrieves the 'purchase_date' input from the request and formats it using the 'formatDate' method.
     * 2. It merges the formatted dates back into the request data.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $formattedPurchaseDate = $this->formatDate($this->input('purchase_date')); // Step 1

        $this->merge([
            'purchase_date' => $formattedPurchaseDate, // Step 2
        ]);
    }

    /**
     * Formats the given date string using Carbon and returns it in 'Y-m-d' format.
     *
     * @param mixed $date The date string to be formatted.
     * @throws \Exception If the date string is invalid.
     * @return string The formatted date string.
     */
    protected function formatDate($date)
    {
        // Parse the given date string using Carbon
        $parsedDate = Carbon::parse($date);

        // Format the parsed date as 'Y-m-d' and return the result
        return $parsedDate->format('Y-m-d');
    }
}
