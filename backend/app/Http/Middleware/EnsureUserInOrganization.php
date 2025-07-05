<?php

namespace App\Http\Middleware;

use App\Repositories\OrganizationRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserInOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Resolve the OrganizationRepository
        $organizationRepository = app(OrganizationRepository::class);

        // Get the organization UUID from the request
        $orgUuid = $request->route('orgUuid');

        // Find the organization using the repository
        $organization = $organizationRepository->findByUuid($orgUuid);

        // Check if the organization exists
        if (!$organization) {
            return response()->json(['error' => 'Organization not found.'], 404);
        }

        // Check if the authenticated user is associated with any organization
        $userOrganizations = $request->user()->organizations;

        // Check if the user is associated with the specified organization
        if (!$userOrganizations->contains('id', $organization->id)) {
            return response()->json(['error' => 'User is not associated with the specified organization.'], 403);
        }

        // Proceed with the request
        return $next($request);
    }
}
