<?php

namespace App\Http\Controllers;

use App\Utils\ErrorMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrganizationRepository;
use App\Http\Resources\OrganizationPhotoResource;
use App\Http\Requests\OrganizationPhotoStoreRequest;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrganizationController extends Controller
{

    private $organizationRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param OrganizationRepositoryInterface $organizationRepository The customer repository.
     */
    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        // Set the organization repository
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Create/Updates a organization photo.
     *
     * @param OrganizationPhotoStoreRequest $request The request object containing the create/updated organization photo data.
     * @param string $uuid The UUID of the organization to be photo create/updated.
     * @throws ModelNotFoundException If the organization with the given UUID does not exist.
     * @return OrganizationPhotoResource The created/updated organization photo resource.
     */
    public function uploadPhoto(OrganizationPhotoStoreRequest $request, string $uuid) {
        try {
            // Validate the request and retrieve the data
            $photo = $request->photo;

            // upload organization photo
            $organizationPhoto = $this->organizationRepository->uploadPhoto($uuid, $photo);

            // Return organization photo
            return new OrganizationPhotoResource($organizationPhoto);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during organization uploadPhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a organization photo.
     *
     * @param string $uuid The UUID of the organization to be photo deleted.
     * @throws \Exception If there is an error during the organization photo deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function deletePhoto(string $uuid) {
        try {

            // deelete customer photo
             $this->organizationRepository->deletePhoto($uuid);

            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during organization deletePhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
