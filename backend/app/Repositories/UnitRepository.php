<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;

class UnitRepository implements UnitRepositoryInterface
{
    /**
     * Creates a new Unit record in the database.
     *
     * @param array $data The data for creating the Unit record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Unit The newly created Unit record.
     */
    public function create(array $data)
    {
        return Unit::create($data);
    }


    /**
     * Update a unit by UUID.
     *
     * @param string $uuid The UUID of the unit.
     * @param array<mixed> $data The data to update the unit with.
     * @return \App\Models\Unit The updated unit.
     */
    public function update(string $uuid, array $data)
    {
        $unit = $this->findByUuid($uuid);
        $unit->update($data);
        return $unit;
    }


    /**
     * Deletes a unit by its UUID.
     *
     * @param string $uuid The UUID of the unit to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the unit.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting unit with UUID: ' . $uuid);
        $unit = Unit::where('uuid', $uuid)->firstOrFail();
        $unit->delete();
    }

    /**
     * Finds an unit by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the unit is not found.
     * @return \App\Models\Unit The found unit.
     */
    public function find(string $uuid)
    {
        return Unit::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a unit by its UUID.
     *
     * @param mixed $uuid The UUID of the unit.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no unit is found.
     * @return Unit The Unit model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Unit::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Unit::all();
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
        return Unit::paginate($perPage);
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
        return Unit::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
