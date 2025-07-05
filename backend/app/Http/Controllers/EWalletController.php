<?php

namespace App\Http\Controllers;

use App\Http\Requests\EWalletPhotoStoreRequest;
use App\Http\Requests\EWalletStoreRequest;
use App\Http\Requests\EWalletUpdateRequest;
use App\Http\Resources\EWalletPhotoResource;
use App\Http\Resources\EWalletResource;
use App\Repositories\EWalletRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EWalletController extends Controller
{
    private $eWalletRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param EWalletRepositoryInterface $eWalletRepository The e-wallet repository.
     */
    public function __construct(EWalletRepositoryInterface $eWalletRepository)
    {
        // Set the e-wallet repository
        $this->eWalletRepository = $eWalletRepository;
    }

    /**
     * Retrieves a paginated collection of e-wallet resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the e-wallet list fetch.
     * @return \App\Http\Resources\EWalletResource A collection of e-wallet resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the e-wallets from the repository
            $eWallets = $this->eWalletRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of e-wallets resources
            return EWalletResource::collection($eWallets);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during eWallet list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a e-wallet by its UUID.
     *
     * @param string $uuid The UUID of the e-wallet.
     * @throws \Exception If there is an error during e-wallet fetch.
     * @return EWalletResource The resource representing the e-wallet.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the e-wallet from the repository
            $eWallet = $this->eWalletRepository->findByUuid($uuid);
            // Return the e-wallet resource
            return new EWalletResource($eWallet);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during e-wallet fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new e-wallet.
     *
     * @param EWalletStoreRequest $request The request object containing the e-wallet data.
     * @throws \Exception If an error occurs during the e-wallet creation.
     * @return EWalletResource The resource representing the created e-wallet.
     */
    public function store(EWalletStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the e-wallet
            $eWallet = $this->eWalletRepository->create($data);
            // Return the e-wallet resource
            return new EWalletResource($eWallet);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during e-wallet creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a e-wallet.
     *
     * @param EWalletUpdateRequest $request The request object containing the updated e-wallet data.
     * @param string $uuid The UUID of the e-wallet to be updated.
     * @throws ModelNotFoundException If the e-wallet with the given UUID does not exist.
     * @return EWalletResource The updated e-wallet resource.
     */
    public function update(EWalletUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the e-wallet
            $eWallet = $this->eWalletRepository->update($uuid, $data);

            // Return the e-wallet resource
            return new EWalletResource($eWallet);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during e-wallet update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a e-wallet.
     *
     * @param string $uuid The UUID of the e-wallet to be deleted.
     * @throws \Exception If there is an error during the e-wallet deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the e-wallet
            $this->eWalletRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during e-wallet deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
