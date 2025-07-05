<?php

namespace App\Repositories;

use App\Models\EWallet;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;

class EWalletRepository implements EWalletRepositoryInterface
{
    /**
     * Creates a new EWallet record in the database.
     *
     * @param array $data The data for creating the EWallet record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return EWallet The newly created EWallet record.
     */
    public function create(array $data)
    {
        return EWallet::create($data);
    }


    /**
     * Update a e-wallet by UUID.
     *
     * @param string $uuid The UUID of the e-wallet.
     * @param array<mixed> $data The data to update the e-wallet with.
     * @return \App\Models\EWallet The updated e-wallet.
     */
    public function update(string $uuid, array $data)
    {
        $eWallet = $this->findByUuid($uuid);
        $eWallet->update($data);
        return $eWallet;
    }


    /**
     * Deletes a e-wallet by its UUID.
     *
     * @param string $uuid The UUID of the e-wallet to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the e-wallet.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting e-wallet with UUID: ' . $uuid);
        $eWallet = EWallet::where('uuid', $uuid)->firstOrFail();
        $eWallet->delete();
    }

    /**
     * Finds an e-wallet by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the e-wallet is not found.
     * @return \App\Models\EWallet The found e-wallet.
     */
    public function find(string $uuid)
    {
        return EWallet::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a e-wallet by its UUID.
     *
     * @param mixed $uuid The UUID of the e-wallet.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no e-wallet is found.
     * @return EWallet The EWallet model instance.
     */
    public function findByUuid(string $uuid)
    {
        return EWallet::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return EWallet::all();
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
        return EWallet::paginate($perPage);
    }

    /**
     * Finds and paginates e-wallets by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated e-wallets.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return EWallet::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
