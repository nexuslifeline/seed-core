<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Repositories\SupplierRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    private $supplierRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param SupplierRepositoryInterface $supplierRepository The supplier repository.
     */
    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        // Set the supplier repository
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Retrieves a paginated collection of supplier resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the supplier list fetch.
     * @return \App\Http\Resources\SupplierResource A collection of supplier resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the suppliers from the repository
            $suppliers = $this->supplierRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of supplier resources
            return SupplierResource::collection($suppliers);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during supplier list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a supplier by its UUID.
     *
     * @param string $uuid The UUID of the supplier.
     * @throws \Exception If there is an error during supplier fetch.
     * @return SupplierResource The resource representing the supplier.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the supplier from the repository
            $supplier = $this->supplierRepository->findByUuid($uuid);
            // Return the supplier resource
            return new SupplierResource($supplier);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during supplier fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new supplier.
     *
     * @param SupplierStoreRequest $request The request object containing the supplier data.
     * @throws \Exception If an error occurs during the supplier creation.
     * @return SupplierResource The resource representing the created supplier.
     */
    public function store(SupplierStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the supplier
            $supplier = $this->supplierRepository->create($data);
            // Return the supplier resource
            return new SupplierResource($supplier);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during supplier creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a supplier.
     *
     * @param SupplierUpdateRequest $request The request object containing the updated supplier data.
     * @param string $uuid The UUID of the supplier to be updated.
     * @throws ModelNotFoundException If the supplier with the given UUID does not exist.
     * @return SupplierResource The updated supplier resource.
     */
    public function update(SupplierUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the supplier
            $supplier = $this->supplierRepository->update($uuid, $data);

            // Return the supplier resource
            return new SupplierResource($supplier);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during supplier update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a supplier.
     *
     * @param string $uuid The UUID of the supplier to be deleted.
     * @throws \Exception If there is an error during the supplier deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the supplier
            $this->supplierRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during supplier deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
