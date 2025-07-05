<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Http\Resources\PurchaseResource;
use App\Repositories\PurchaseItemRepositoryInterface;
use App\Repositories\PurchaseRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    private $purchaseRepository;
    private $purchaseItemRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param PurchaseRepositoryInterface $purchaseRepository The purchase repository.
     */
    public function __construct(
        PurchaseRepositoryInterface $purchaseRepository,
        PurchaseItemRepositoryInterface $purchaseItemRepository
    ) {
        // Set the purchase repository
        $this->purchaseRepository = $purchaseRepository;
        $this->purchaseItemRepository = $purchaseItemRepository;
    }

    /**
     * Retrieves a paginated collection of purchase resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the purchase list fetch.
     * @return \App\Http\Resources\PurchaseResource A collection of purchase resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the purchases from the repository
            $purchases = $this->purchaseRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of purchase resources
            return PurchaseResource::collection($purchases);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during purchase list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a purchase by its UUID.
     *
     * @param string $uuid The UUID of the purchase.
     * @throws \Exception If there is an error during purchase fetch.
     * @return PurchaseResource The resource representing the purchase.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the purchase from the repository
            $purchase = $this->purchaseRepository->findByUuid($uuid);
            // Return the purchase resource
            return new PurchaseResource($purchase);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during purchase fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new purchase.
     *
     * @param PurchaseStoreRequest $request The request object containing the purchase data.
     * @throws \Exception If an error occurs during the purchase creation.
     * @return PurchaseResource The resource representing the created purchase.
     */
    public function store(PurchaseStoreRequest $request)
    {
        // Log::info($request->all());
        // Log::info("Purchase creation request received.");
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the purchase
            $purchase = $this->purchaseRepository->create($data);

            // Return the purchase resource
            return new PurchaseResource($purchase);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during purchase creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a purchase.
     *
     * @param PurchaseUpdateRequest $request The request object containing the updated purchase data.
     * @param string $uuid The UUID of the purchase to be updated.
     * @throws ModelNotFoundException If the purchase with the given UUID does not exist.
     * @return PurchaseResource The updated purchase resource.
     */
    public function update(PurchaseUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the purchase
            $purchase = $this->purchaseRepository->update($uuid, $data);

            // Return the purchase resource
            return new PurchaseResource($purchase);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during purchase update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a purchase.
     *
     * @param string $uuid The UUID of the purchase to be deleted.
     * @throws \Exception If there is an error during the purchase deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the purchase
            $this->purchaseRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during purchase deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
