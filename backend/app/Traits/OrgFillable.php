<?php

namespace App\Traits;

use App\Repositories\OrganizationRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait OrgFillable
{
    /**
     * Boot method to register event listeners.
     */
    protected static function bootOrgFillable()
    {

        // fired before creating
        static::creating(function ($model) {
            // Access the route parameters to get orgUuid
            $orgUuid = request()->route('orgUuid');

            // Resolve the OrganizationRepository
            $organizationRepository = app(OrganizationRepository::class);

            // Find the organization by the given UUID
            $organization = $organizationRepository->findByUuid($orgUuid);

            // Set the organization_id attribute on the product
            $model->organization_id = $organization->id;
        });
    }
}
