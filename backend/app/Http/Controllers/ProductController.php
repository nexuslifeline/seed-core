<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPhotoStoreRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductPhotoResource;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $productRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param ProductRepositoryInterface $productRepository The product repository.
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        // Set the product repository
        $this->productRepository = $productRepository;
    }

    /**
     * Retrieves a paginated collection of product resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the product list fetch.
     * @return \App\Http\Resources\ProductResource A collection of product resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the products from the repository
            $products = $this->productRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of product resources
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a product by its UUID.
     *
     * @param string $uuid The UUID of the product.
     * @throws \Exception If there is an error during product fetch.
     * @return ProductResource The resource representing the product.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the product from the repository
            $product = $this->productRepository->findByUuid($uuid);
            // Load the related models (unit, organization, category)
            $product->load([
                'unit:id,uuid,name',
                'category:id,uuid,name',
                'organization:id,uuid,name'
            ]);
            // Return the product resource
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new product.
     *
     * @param ProductStoreRequest $request The request object containing the product data.
     * @throws \Exception If an error occurs during the product creation.
     * @return ProductResource The resource representing the created product.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the product
            $product = $this->productRepository->create($data);
            // Load the related models (unit, organization, category)
            $product->load([
                'unit:id,uuid,name',
                'category:id,uuid,name',
                'organization:id,uuid,name'
            ]);
            // Return the product resource
            return new ProductResource($product);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a product.
     *
     * @param ProductUpdateRequest $request The request object containing the updated product data.
     * @param string $uuid The UUID of the product to be updated.
     * @throws ModelNotFoundException If the product with the given UUID does not exist.
     * @return ProductResource The updated product resource.
     */
    public function update(ProductUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the product
            $product = $this->productRepository->update($uuid, $data);

            // Load the related models (unit, organization, category)
            $product->load([
                'unit:id,uuid,name',
                'category:id,uuid,name',
                'organization:id,uuid,name'
            ]);

            // Return the product resource
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a product.
     *
     * @param string $uuid The UUID of the product to be deleted.
     * @throws \Exception If there is an error during the product deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the product
            $this->productRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create/Updates a product photo.
     *
     * @param ProductPhotoStoreRequest $request The request object containing the create/updated product photo data.
     * @param string $uuid The UUID of the product to be photo updated.
     * @throws ModelNotFoundException If the product with the given UUID does not exist.
     * @return ProductPhotoResource The created/updated product photo resource.
     */
    public function uploadPhoto(ProductPhotoStoreRequest $request, string $orgUuid, string $uuid) {
        try {
            // Validate the request and retrieve the data
            $photo = $request->photo;

            // upload customer photo
            $productPhoto = $this->productRepository->uploadPhoto($uuid, $photo);

            // Return customer photo
            return new ProductPhotoResource($productPhoto);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product uploadPhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Deletes a product photo.
     *
     * @param string $uuid The UUID of the product to be photo deleted.
     * @throws \Exception If there is an error during the product photo deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function deletePhoto(string $orgUuid, string $uuid) {
        try {

            // deelete customer photo
            $this->productRepository->deletePhoto($uuid);

            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during product deletePhoto. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
