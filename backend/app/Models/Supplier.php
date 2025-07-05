<?php

namespace App\Models;

use App\Traits\OrgFillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends BaseModel
{
    use OrgFillable;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
