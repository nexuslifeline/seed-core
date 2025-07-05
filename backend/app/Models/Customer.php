<?php

namespace App\Models;

use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends BaseModel
{
    use OrgFillable;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(CustomerPhoto::class);
    }
}
