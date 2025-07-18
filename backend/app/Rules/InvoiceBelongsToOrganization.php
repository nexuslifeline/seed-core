<?php

namespace App\Rules;

use Closure;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Contracts\Validation\ValidationRule;

class InvoiceBelongsToOrganization implements ValidationRule
{
    protected $orgUuid;
    /**
     * Constructor for the class.
     *
     * @param string                          $orgUuid              The UUID of the organization.
     */
    public function __construct(string $orgUuid)
    {
        $this->orgUuid = $orgUuid;
    }

    /**
     * Validates a given attribute value against the customer's organization UUID.
     *
     * @param string $attribute The name of the attribute being validated.
     * @param mixed $value The value of the attribute being validated.
     * @param Closure $fail The closure to be called if the validation fails.
     * @throws Exception If the customer does not belong to the organization.
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // Find the invoice by UUID using the invoice repository
        $invoice = Invoice::with('organization')->find($value);

        // Check if the invoice's organization UUID is not equal to the organization UUID provided
        if (!$this->orgUuid || !$invoice || !$invoice->organization || $invoice->organization->uuid !== $this->orgUuid) {
            // Call the fail closure with a message if the validation fails
            $fail('The invoice does not belong to the organization.');
        }
    }
}
