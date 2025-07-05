<?php

namespace App\Http\Requests;

use App\Rules\CustomerBelongsToOrganization;
use Carbon\Carbon;

class InvoiceUpdateRequest extends BaseFormRequest
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
            // The 'customer_id' field is required and must exist in the 'customers' table
            'customer_id' => [
                'required',
                'exists:customers,id',
                new CustomerBelongsToOrganization($this->route('orgUuid')),
            ],
            // The 'issue_date' field is required and must be a valid date
            'issue_date' => 'required|date',
            // The 'due_date' field is required, must be a valid date, and must be after or equal to the 'issue_date' field
            'due_date' => 'required|date|after_or_equal:issue_date',
            // The 'total_amount' field is required, must be numeric, and must be greater than or equal to 0
            'total_amount' => 'required|numeric|min:0',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * This method is responsible for preparing the data that needs to be validated
     * before it is passed to the validation rules. It performs the following steps:
     * 1. It retrieves the 'issue_date' input from the request and formats it using the 'formatDate' method.
     * 2. It retrieves the 'due_date' input from the request and formats it using the 'formatDate' method.
     * 3. It merges the formatted dates back into the request data.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $formattedInvoiceDate = $this->formatDate($this->input('issue_date')); // Step 1
        $formattedDueDate = $this->formatDate($this->input('due_date')); // Step 2

        $this->merge([
            'issue_date' => $formattedInvoiceDate, // Step 3
            'due_date' => $formattedDueDate, // Step 3
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
