<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Rules\BankBelongsToOrganization;
use App\Rules\EWalletBelongsToOrganization;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CustomerBelongsToOrganization;
use App\Rules\InvoiceBelongsToOrganization;

class PaymentStoreRequest extends BaseFormRequest
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
            'customer_id' => [
                'required',
                'exists:customers,id',
                new CustomerBelongsToOrganization($this->route('orgUuid'))
            ],
            'bank_id' => [
                'required_if:payment_type,bank',
                'exists:banks,id',
                new BankBelongsToOrganization($this->route('orgUuid'))
            ],
            'e_wallet_id' => [
                'required_if:payment_type,e-wallet',
                'exists:e_wallets,id',
                new EWalletBelongsToOrganization($this->route('orgUuid'))
            ],
            'payment_type' => 'required|in:cash,bank,e-wallet', //TODO: change to enum ?
            'payment_type_reference_no' => ['required_if:payment_type,bank,e-wallet'],
            'payment_type_reference_date' => ['required_if:payment_type,bank,e-wallet|date'],
            'payment_date' => 'required|date',
            'invoices' => ['array', 'min:1'],
            'invoices.*.invoice_id' => [
                'required',
                'exists:invoices,id',
                new InvoiceBelongsToOrganization($this->route('orgUuid'))
            ],
            'invoices.*.line_total' => 'required|numeric|min:0',
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
        //format payment date
        $formattedPaymentDate = $this->formatDate($this->input('payment_date'));

        //merge formatted payment date on request
        $this->merge([
            'payment_date' => $formattedPaymentDate,
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


    /**
     * Override the default attributes for the request.
     *
     * * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'customer_id' => 'customer',
            'bank_id' => 'bank',
            'e_wallet_id' => 'e-wallet',
            'invoices.*.invoice_id' => 'invoice id',
            'invoices.*.line_total' => 'line total paid',
        ];
    }
}
