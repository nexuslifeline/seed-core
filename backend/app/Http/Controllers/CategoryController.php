<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private $categoryRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param CategoryRepositoryInterface $categoryRepository The category repository.
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        // Set the category repository
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Retrieves a paginated collection of category resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the category list fetch.
     * @return \App\Http\Resources\CategoryResource A collection of category resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            //retrive search param
            $search = $request->input('search');
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the categories from the repository
            $categories = $this->categoryRepository->findByOrgUuidAndPaginate($orgUuid, $perPage, $search);
            // Return a collection of category resources
            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during category list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a category by its UUID.
     *
     * @param string $uuid The UUID of the category.
     * @throws \Exception If there is an error during category fetch.
     * @return CategoryResource The resource representing the category.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the category from the repository
            $category = $this->categoryRepository->findByUuid($uuid);
            // Return the category resource
            return new CategoryResource($category);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during category fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new category.
     *
     * @param CategoryStoreRequest $request The request object containing the category data.
     * @throws \Exception If an error occurs during the category creation.
     * @return CategoryResource The resource representing the created category.
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the category
            $category = $this->categoryRepository->create($data);
            // Return the category resource
            return new CategoryResource($category);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during category creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a category.
     *
     * @param CategoryUpdateRequest $request The request object containing the updated category data.
     * @param string $uuid The UUID of the category to be updated.
     * @throws ModelNotFoundException If the category with the given UUID does not exist.
     * @return CategoryResource The updated category resource.
     */
    public function update(CategoryUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the category
            $category = $this->categoryRepository->update($uuid, $data);

            // Return the category resource
            return new CategoryResource($category);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during category update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a category.
     *
     * @param string $uuid The UUID of the category to be deleted.
     * @throws \Exception If there is an error during the category deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the category
            $this->categoryRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during category deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
