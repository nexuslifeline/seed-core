<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentItemRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $paymentRepository;
    private $paymentItemRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param PaymentRepositoryInterface $paymentRepository The payment repository.
     */
    public function __construct(
        PaymentRepositoryInterface $paymentRepository
    ) {
        // Set the payment repository
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Retrieves a paginated collection of payment resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the payment list fetch.
     * @return \App\Http\Resources\PaymentResource A collection of payment resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the payments from the repository
            $payments = $this->paymentRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of payment resources
            return PaymentResource::collection($payments);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during payment list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a payment by its UUID.
     *
     * @param string $uuid The UUID of the payment.
     * @throws \Exception If there is an error during payment fetch.
     * @return PaymentResource The resource representing the payment.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the payment from the repository
            $payment = $this->paymentRepository->findByUuid($uuid);
            // Return the payment resource
            return new PaymentResource($payment);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during payment fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new payment.
     *
     * @param PaymentStoreRequest $request The request object containing the payment data.
     * @throws \Exception If an error occurs during the payment creation.
     * @return PaymentResource The resource representing the created payment.
     */
    public function store(PaymentStoreRequest $request)
    {
        // Log::info($request->all());
        // Log::info("Payment creation request received.");
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the payment
            $payment = $this->paymentRepository->create($data);

            // Return the payment resource
            return new PaymentResource($payment);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during payment creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a payment.
     *
     * @param PaymentUpdateRequest $request The request object containing the updated payment data.
     * @param string $uuid The UUID of the payment to be updated.
     * @throws ModelNotFoundException If the payment with the given UUID does not exist.
     * @return PaymentResource The updated payment resource.
     */
    public function update(PaymentUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the payment
            $payment = $this->paymentRepository->update($uuid, $data);

            // Return the payment resource
            return new PaymentResource($payment);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during payment update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a payment.
     *
     * @param string $uuid The UUID of the payment to be deleted.
     * @throws \Exception If there is an error during the payment deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the payment
            $this->paymentRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during payment deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
