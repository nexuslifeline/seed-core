<?php

namespace App\Repositories;

use App\Models\PaymentTerm;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;

class PaymentTermRepository implements PaymentTermRepositoryInterface
{
    /**
     * Creates a new PaymentTerm record in the database.
     *
     * @param array $data The data for creating the PaymentTerm record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return PaymentTerm The newly created PaymentTerm record.
     */
    public function create(array $data)
    {
        return PaymentTerm::create($data);
    }


    /**
     * Update a paymentTerm by UUID.
     *
     * @param string $uuid The UUID of the paymentTerm.
     * @param array<mixed> $data The data to update the paymentTerm with.
     * @return \App\Models\PaymentTerm The updated paymentTerm.
     */
    public function update(string $uuid, array $data)
    {
        $paymentTerm = $this->findByUuid($uuid);
        $paymentTerm->update($data);
        return $paymentTerm;
    }


    /**
     * Deletes a paymentTerm by its UUID.
     *
     * @param string $uuid The UUID of the paymentTerm to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the paymentTerm.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting paymentTerm with UUID: ' . $uuid);
        $paymentTerm = PaymentTerm::where('uuid', $uuid)->firstOrFail();
        $paymentTerm->delete();
    }

    /**
     * Finds an paymentTerm by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the paymentTerm is not found.
     * @return \App\Models\PaymentTerm The found paymentTerm.
     */
    public function find(string $uuid)
    {
        return PaymentTerm::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a paymentTerm by its UUID.
     *
     * @param mixed $uuid The UUID of the paymentTerm.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no paymentTerm is found.
     * @return PaymentTerm The PaymentTerm model instance.
     */
    public function findByUuid(string $uuid)
    {
        return PaymentTerm::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return PaymentTerm::all();
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
        return PaymentTerm::paginate($perPage);
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
        return PaymentTerm::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
