<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerPhoto;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Creates a new Customer record in the database.
     *
     * @param array $data The data for creating the Customer record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Customer The newly created Customer record.
     */
    public function create(array $data)
    {
        return Customer::create($data);
    }


    /**
     * Update a category by UUID.
     *
     * @param string $uuid The UUID of the category.
     * @param array<mixed> $data The data to update the category with.
     * @return \App\Models\Customer The updated category.
     */
    public function update(string $uuid, array $data)
    {
        $category = $this->findByUuid($uuid);
        $category->update($data);
        return $category;
    }


    /**
     * Deletes a category by its UUID.
     *
     * @param string $uuid The UUID of the category to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the category.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting category with UUID: ' . $uuid);
        $category = Customer::where('uuid', $uuid)->firstOrFail();
        $category->delete();
    }

    /**
     * Finds an category by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the category is not found.
     * @return \App\Models\Customer The found category.
     */
    public function find(string $uuid)
    {
        return Customer::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a category by its UUID.
     *
     * @param mixed $uuid The UUID of the category.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no category is found.
     * @return Customer The Customer model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Customer::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Customer::all();
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
        return Customer::paginate($perPage);
    }

    /**
     * Finds and paginates products by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated products.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Customer::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }

    /**
     * Finds and paginates products by organization UUID.
     *
     * @param string $uuid The UUID of the customer.
     * @param object $photo The image to be uploaded.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return App\\Models\\CustomerPhoto The paginated products.
     */
    public function uploadPhoto(string $uuid, $photo)
    {
        //find organization
        $customer = $this->findByUuid($uuid);

        //photo resizing
        $image = Image::make($photo)->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });
        //set photo path
        $path = 'public/photos/customers/' . $photo->hashName();
        //store photo on storage
        Storage::put($path, $image->stream());

        $customerPhoto = CustomerPhoto::updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'path' => $path,
                'name' => $photo->getClientOriginalName(),
                'hash_name' => $photo->hashName()
            ]
        );

        return $customerPhoto;
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
        $customer = $this->findByUuid($uuid);

        //get current photo
        $customerPhoto = CustomerPhoto::where('customer_id', $customer->id)->first();

        if($customerPhoto) {
            //delete on storage
            Storage::delete($customerPhoto->path);
            //delete on database
            $customerPhoto->delete();
            return true;
        }

        return false;
    }

}
