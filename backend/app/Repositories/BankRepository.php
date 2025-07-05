<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;

class BankRepository implements BankRepositoryInterface
{
    /**
     * Creates a new Bank record in the database.
     *
     * @param array $data The data for creating the Bank record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Bank The newly created Bank record.
     */
    public function create(array $data)
    {
        return Bank::create($data);
    }


    /**
     * Update a bank by UUID.
     *
     * @param string $uuid The UUID of the bank.
     * @param array<mixed> $data The data to update the bank with.
     * @return \App\Models\Bank The updated bank.
     */
    public function update(string $uuid, array $data)
    {
        $bank = $this->findByUuid($uuid);
        $bank->update($data);
        return $bank;
    }


    /**
     * Deletes a bank by its UUID.
     *
     * @param string $uuid The UUID of the bank to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the bank.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting bank with UUID: ' . $uuid);
        $bank = Bank::where('uuid', $uuid)->firstOrFail();
        $bank->delete();
    }

    /**
     * Finds an bank by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the bank is not found.
     * @return \App\Models\Bank The found bank.
     */
    public function find(string $uuid)
    {
        return Bank::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a bank by its UUID.
     *
     * @param mixed $uuid The UUID of the bank.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no bank is found.
     * @return Bank The Bank model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Bank::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Bank::all();
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
        return Bank::paginate($perPage);
    }

    /**
     * Finds and paginates banks by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated banks.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Bank::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
