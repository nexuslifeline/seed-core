<?php

namespace App\Models;

use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EWallet extends BaseModel
{
    use OrgFillable;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
