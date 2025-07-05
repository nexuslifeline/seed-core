<?php

namespace App\Http\Controllers;


use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;
use App\Http\Resources\BankResource;
use App\Repositories\BankRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    private $bankRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param BankRepositoryInterface $bankRepository The bank repository.
     */
    public function __construct(BankRepositoryInterface $bankRepository)
    {
        // Set the bank repository
        $this->bankRepository = $bankRepository;
    }

    /**
     * Retrieves a paginated collection of bank resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the bank list fetch.
     * @return \App\Http\Resources\BankResource A collection of bank resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the banks from the repository
            $banks = $this->bankRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of bank resources
            return BankResource::collection($banks);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during bank list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a bank by its UUID.
     *
     * @param string $uuid The UUID of the bank.
     * @throws \Exception If there is an error during bank fetch.
     * @return BankResource The resource representing the bank.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the bank from the repository
            $bank = $this->bankRepository->findByUuid($uuid);
            // Return the bank resource
            return new BankResource($bank);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during bank fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new bank.
     *
     * @param BankStoreRequest $request The request object containing the bank data.
     * @throws \Exception If an error occurs during the bank creation.
     * @return BankResource The resource representing the created bank.
     */
    public function store(BankStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the bank
            $bank = $this->bankRepository->create($data);
            // Return the bank resource
            return new BankResource($bank);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during bank creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a bank.
     *
     * @param BankUpdateRequest $request The request object containing the updated bank data.
     * @param string $uuid The UUID of the bank to be updated.
     * @throws ModelNotFoundException If the bank with the given UUID does not exist.
     * @return BankResource The updated bank resource.
     */
    public function update(BankUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the bank
            $bank = $this->bankRepository->update($uuid, $data);

            // Return the bank resource
            return new BankResource($bank);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during bank update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a bank.
     *
     * @param string $uuid The UUID of the bank to be deleted.
     * @throws \Exception If there is an error during the bank deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the bank
            $this->bankRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during bank deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
