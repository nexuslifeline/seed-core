<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Models\SupplierPhoto;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class SupplierRepository implements SupplierRepositoryInterface
{
    /**
     * Creates a new Supplier record in the database.
     *
     * @param array $data The data for creating the Supplier record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Supplier The newly created Supplier record.
     */
    public function create(array $data)
    {
        return Supplier::create($data);
    }


    /**
     * Update a supplier by UUID.
     *
     * @param string $uuid The UUID of the supplier.
     * @param array<mixed> $data The data to update the supplier with.
     * @return \App\Models\Supplier The updated supplier.
     */
    public function update(string $uuid, array $data)
    {
        $supplier = $this->findByUuid($uuid);
        $supplier->update($data);
        return $supplier;
    }


    /**
     * Deletes a supplier by its UUID.
     *
     * @param string $uuid The UUID of the supplier to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the supplier.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting supplier with UUID: ' . $uuid);
        $supplier = Supplier::where('uuid', $uuid)->firstOrFail();
        $supplier->delete();
    }

    /**
     * Finds an supplier by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the supplier is not found.
     * @return \App\Models\Supplier The found supplier.
     */
    public function find(string $uuid)
    {
        return Supplier::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a supplier by its UUID.
     *
     * @param mixed $uuid The UUID of the supplier.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no supplier is found.
     * @return Supplier The Supplier model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Supplier::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Supplier::all();
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
        return Supplier::paginate($perPage);
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
        return Supplier::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }

}
