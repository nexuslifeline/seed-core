<?php

namespace App\Models;
use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends BaseModel
{
    use OrgFillable;


    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function eWallet(): BelongsTo
    {
        return $this->belongsTo(EWallet::class);
    }

    public function paymentInvoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'payment_invoices', 'payment_id', 'invoice_id')
            ->withPivot('line_total', 'notes')
            ->using(PaymentInvoice::class);
    }
}
