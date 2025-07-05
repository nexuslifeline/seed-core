<?php

namespace App\Models;

use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTerm extends BaseModel
{
    use OrgFillable;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
