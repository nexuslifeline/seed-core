<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class ProductBelongsToOrganization implements ValidationRule
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
     * Validates a given attribute value against the product's organization UUID.
     *
     * @param string $attribute The name of the attribute being validated.
     * @param mixed $value The value of the attribute being validated.
     * @param Closure $fail The closure to be called if the validation fails.
     * @throws Exception If the product does not belong to the organization.
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // TODO: use repository pattern to load the product
        // Find the product by UUID using the product repository
        $product = Product::with('organization')->find($value);
        // Check if the product's organization UUID is not equal to the organization UUID provided
        if (!$this->orgUuid || !$product || !$product->organization || $product->organization->uuid !== $this->orgUuid) {
            // Call the fail closure with a message if the validation fails
            $fail('The product does not belong to the organization.');
        }
    }
}
