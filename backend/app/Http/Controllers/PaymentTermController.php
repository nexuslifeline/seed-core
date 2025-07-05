<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentTermStoreRequest;
use App\Http\Requests\PaymentTermUpdateRequest;
use App\Http\Resources\PaymentTermResource;
use App\Repositories\PaymentTermRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PaymentTermController extends Controller
{
    private $paymentTermRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param PaymentTermRepositoryInterface $paymentTermRepository The paymentTerm repository.
     */
    public function __construct(PaymentTermRepositoryInterface $paymentTermRepository)
    {
        // Set the paymentTerm repository
        $this->paymentTermRepository = $paymentTermRepository;
    }

    /**
     * Retrieves a paginated collection of paymentTerm resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the paymentTerm list fetch.
     * @return \App\Http\Resources\PaymentTermResource A collection of paymentTerm resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the categories from the repository
            $categories = $this->paymentTermRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of paymentTerm resources
            return PaymentTermResource::collection($categories);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during paymentTerm list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a paymentTerm by its UUID.
     *
     * @param string $uuid The UUID of the paymentTerm.
     * @throws \Exception If there is an error during paymentTerm fetch.
     * @return PaymentTermResource The resource representing the paymentTerm.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the paymentTerm from the repository
            $paymentTerm = $this->paymentTermRepository->findByUuid($uuid);
            // Return the paymentTerm resource
            return new PaymentTermResource($paymentTerm);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during paymentTerm fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new paymentTerm.
     *
     * @param PaymentTermStoreRequest $request The request object containing the paymentTerm data.
     * @throws \Exception If an error occurs during the paymentTerm creation.
     * @return PaymentTermResource The resource representing the created paymentTerm.
     */
    public function store(PaymentTermStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the paymentTerm
            $paymentTerm = $this->paymentTermRepository->create($data);
            // Return the paymentTerm resource
            return new PaymentTermResource($paymentTerm);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during paymentTerm creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a paymentTerm.
     *
     * @param PaymentTermUpdateRequest $request The request object containing the updated paymentTerm data.
     * @param string $uuid The UUID of the paymentTerm to be updated.
     * @throws ModelNotFoundException If the paymentTerm with the given UUID does not exist.
     * @return PaymentTermResource The updated paymentTerm resource.
     */
    public function update(PaymentTermUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the paymentTerm
            $paymentTerm = $this->paymentTermRepository->update($uuid, $data);

            // Return the paymentTerm resource
            return new PaymentTermResource($paymentTerm);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during paymentTerm update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a paymentTerm.
     *
     * @param string $uuid The UUID of the paymentTerm to be deleted.
     * @throws \Exception If there is an error during the paymentTerm deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the paymentTerm
            $this->paymentTermRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during paymentTerm deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
