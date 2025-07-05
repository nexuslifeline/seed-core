<?php

namespace App\Models;

use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends BaseModel
{
    use OrgFillable;

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function setting(): HasOne
    {
        return $this->hasOne(InvoiceSetting::class);
    }

    public function paymentInvoices(): HasMany {
        return $this->hasMany(PaymentInvoice::class)
            ->whereHas('payment');
    }

    public function getTotalPaidAttribute() {
        return $this->paymentInvoices()->sum('line_total');
    }

}
