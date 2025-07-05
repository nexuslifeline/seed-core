<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BelongsToOrganization
{
    const DEFAULT_EXEMPTED_ACTIONS = ['index', 'store'];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $modelClass, ...$exemptedActions): Response
    {
        $exemptedActions = $exemptedActions ?: self::DEFAULT_EXEMPTED_ACTIONS;
        // Get the organization UUID from the request route
        $orgUuid = $request->route('orgUuid');

        // Get the resource UUID from the request route
        // This is the parameter name defined in the API route
        // By default, this will be the resource name
        $resourceUuid = $request->route('uuid');

        // Get the base name of the model class
        $name = class_basename($modelClass);
        // Get the name of the current action
        $currentAction = $request->route()->getActionMethod();

        // Check if the current route matches any of the exempted endpoints
        if (Arr::first($exemptedActions, function ($pattern) use ($currentAction) {
            return $pattern === $currentAction;
        })) {
            // If the current route matches any of the exempted endpoints, skip the middleware logic
            return $next($request);
        }

        // Dynamically construct the model class name based on the provided $modelClass
        $model = app('App\\Models\\' . $modelClass);

        // Retrieve the resource based on the resource UUID
        $resource = $model::where('uuid', $resourceUuid)->first();

        // If the resource does not exist, return a JSON response with an error message and status code 404
        if (!$resource) {
            return response()->json(['error' => "{$name} not found"], 404);
        }

        // Eager load the "organization" relationship of the resource
        $resource->load('organization');

        // If the organization UUID from the request does not match the resource's organization UUID,
        // return a JSON response with an error message and status code 404
        if ($orgUuid !== $resource->organization->uuid) {
            return response()->json(['error' => "{$name} does not belong to the organization"], 404);
        }

        // Call the next middleware or the final request handler with the request
        return $next($request);
    }
}
