<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerPhotoStoreRequest;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerPhotoResource;
use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    private $customerRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param CustomerRepositoryInterface $customerRepository The customer repository.
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        // Set the customer repository
        $this->customerRepository = $customerRepository;
    }

    /**
     * Retrieves a paginated collection of customer resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the customer list fetch.
     * @return \App\Http\Resources\CustomerResource A collection of customer resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the customers from the repository
            $customers = $this->customerRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of customer resources
            return CustomerResource::collection($customers);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a customer by its UUID.
     *
     * @param string $uuid The UUID of the customer.
     * @throws \Exception If there is an error during customer fetch.
     * @return CustomerResource The resource representing the customer.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the customer from the repository
            $customer = $this->customerRepository->findByUuid($uuid);
            // Return the customer resource
            return new CustomerResource($customer);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new customer.
     *
     * @param CustomerStoreRequest $request The request object containing the customer data.
     * @throws \Exception If an error occurs during the customer creation.
     * @return CustomerResource The resource representing the created customer.
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the customer
            $customer = $this->customerRepository->create($data);
            // Return the customer resource
            return new CustomerResource($customer);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a customer.
     *
     * @param CustomerUpdateRequest $request The request object containing the updated customer data.
     * @param string $uuid The UUID of the customer to be updated.
     * @throws ModelNotFoundException If the customer with the given UUID does not exist.
     * @return CustomerResource The updated customer resource.
     */
    public function update(CustomerUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the customer
            $customer = $this->customerRepository->update($uuid, $data);

            // Return the customer resource
            return new CustomerResource($customer);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a customer.
     *
     * @param string $uuid The UUID of the customer to be deleted.
     * @throws \Exception If there is an error during the customer deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the customer
            $this->customerRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create/Updates a customer photo.
     *
     * @param CustomerPhotoStoreRequest $request The request object containing the create/updated customer photo data.
     * @param string $uuid The UUID of the customer to be photo create/updated.
     * @throws ModelNotFoundException If the customer with the given UUID does not exist.
     * @return CustomerPhotoStoreRequest The created/updated customer photo resource.
     */
    public function uploadPhoto(CustomerPhotoStoreRequest $request, string $orgUuid, string $uuid) {
        try {
            // Validate the request and retrieve the data
            $photo = $request->photo;

            // upload customer photo
            $customerPhoto = $this->customerRepository->uploadPhoto($uuid, $photo);

            // Return customer photo
            return new CustomerPhotoResource($customerPhoto);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer uploadPhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a customer photo.
     *
     * @param string $uuid The UUID of the customer to be photo deleted.
     * @throws \Exception If there is an error during the customer photo deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function deletePhoto(string $orgUuid, string $uuid) {
        try {

            // deelete customer photo
            $this->customerRepository->deletePhoto($uuid);

            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during customer deletePhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
