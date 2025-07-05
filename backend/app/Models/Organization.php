<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends BaseModel
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(OrganizationPhoto::class);
    }
}
