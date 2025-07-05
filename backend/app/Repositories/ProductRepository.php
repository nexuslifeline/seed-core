<?php

namespace App\Repositories;

use Image;
use App\Models\Product;
use App\Utils\Constants;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Creates a new Product record in the database.
     *
     * @param array $data The data for creating the Product record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Product The newly created Product record.
     */
    public function create(array $data)
    {
        return Product::create($data);
    }


    /**
     * Update a product by UUID.
     *
     * @param string $uuid The UUID of the product.
     * @param array<mixed> $data The data to update the product with.
     * @return \App\Models\Product The updated product.
     */
    public function update(string $uuid, array $data)
    {
        $product = $this->findByUuid($uuid);
        $product->update($data);
        return $product;
    }


    /**
     * Deletes a product by its UUID.
     *
     * @param string $uuid The UUID of the product to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the product.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting product with UUID: ' . $uuid);
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $product->delete();
    }

    /**
     * Finds an product by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the product is not found.
     * @return \App\Models\Product The found product.
     */
    public function find(string $uuid)
    {
        return Product::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a product by its UUID.
     *
     * @param mixed $uuid The UUID of the product.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no product is found.
     * @return Product The Product model instance.
     */
    public function findByUuid($uuid)
    {
        return Product::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Product::with(['unit:id,uuid,name', 'category:id,uuid,name'])->get();
    }

    /**
     * Paginate the results of the query.
     *
     * @param int $perPage The number of items per page.
     * @throws Some_Exception_Class Description of exception.
     * @return \Illuminate\Contracts\Pagination\Paginator The paginated results.
     */
    public function paginate(?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Product::with(['unit:id,uuid,name', 'category:id,uuid,name'])->paginate($perPage);
    }

    /**
     * Find records by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int $perPage The number of records to return per page.
     * @throws Some_Exception_Class A description of the exception that may be thrown.
     * @return Some_Return_Value A description of the return value.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Product::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })
            ->with(['unit:id,uuid,name', 'category:id,uuid,name'])
            ->paginate($perPage);
    }


    /**
     * Finds and paginates products by organization UUID.
     *
     * @param string $uuid The UUID of the product.
     * @param object $photo The image to be uploaded.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return App\\Models\\ProductPhoto
     */
    public function uploadPhoto(string $uuid, $photo)
    {
        //find organization
        $product = $this->findByUuid($uuid);

        //photo resizing
        $image = Image::make($photo)->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });
        //set photo path
        $path = 'public/photos/products/' . $photo->hashName();
        //store photo on storage
        Storage::put($path, $image->stream());

        $productPhoto = ProductPhoto::updateOrCreate(
            ['product_id' => $product->id],
            [
                'path' => $path,
                'name' => $photo->getClientOriginalName(),
                'hash_name' => $photo->hashName()
            ]
        );

        return $productPhoto;
    }

    /**
     * Deletes a category by its UUID.
     *
     * @param string $uuid The UUID of the customer to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the category.
     * @return void
     */
    public function deletePhoto(string $uuid)
    {
        //find organization
        $product = $this->findByUuid($uuid);

        //get current photo
        $productPhoto = ProductPhoto::where('product_id', $product->id)->first();

        if($productPhoto) {
            //delete on storage
            Storage::delete($productPhoto->path);
            //delete on database
            $productPhoto->delete();
            return true;
        }

        return false;
    }
}
