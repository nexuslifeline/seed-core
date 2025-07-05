<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Repositories\UnitRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    private $unitRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param UnitRepositoryInterface $unitRepository The unit repository.
     */
    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        // Set the unit repository
        $this->unitRepository = $unitRepository;
    }

    /**
     * Retrieves a paginated collection of unit resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the unit list fetch.
     * @return \App\Http\Resources\UnitResource A collection of unit resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the units from the repository
            $units = $this->unitRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of unit resources
            return UnitResource::collection($units);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during unit list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a unit by its UUID.
     *
     * @param string $uuid The UUID of the unit.
     * @throws \Exception If there is an error during unit fetch.
     * @return UnitResource The resource representing the unit.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the unit from the repository
            $unit = $this->unitRepository->findByUuid($uuid);
            // Return the unit resource
            return new UnitResource($unit);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during unit fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new unit.
     *
     * @param UnitStoreRequest $request The request object containing the unit data.
     * @throws \Exception If an error occurs during the unit creation.
     * @return UnitResource The resource representing the created unit.
     */
    public function store(UnitStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the unit
            $unit = $this->unitRepository->create($data);
            // Return the unit resource
            return new UnitResource($unit);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during unit creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a unit.
     *
     * @param UnitUpdateRequest $request The request object containing the updated unit data.
     * @param string $uuid The UUID of the unit to be updated.
     * @throws ModelNotFoundException If the unit with the given UUID does not exist.
     * @return UnitResource The updated unit resource.
     */
    public function update(UnitUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the unit
            $unit = $this->unitRepository->update($uuid, $data);

            // Return the unit resource
            return new UnitResource($unit);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during unit update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a unit.
     *
     * @param string $uuid The UUID of the unit to be deleted.
     * @throws \Exception If there is an error during the unit deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the unit
            $this->unitRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during unit deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
