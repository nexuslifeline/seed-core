<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Utils\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    /**
     * Creates a new Purchase record in the database.
     *
     * @param array $data The data for creating the Purchase record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Purchase The newly created Purchase record.
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        $purchase = Purchase::create($data);

        $items = $data['items'] ?? [];
        // Save related items
        if (count($items) > 0) {
            foreach ($items as $item) {
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['line_total'],
                ]);
            }
        }
        DB::commit();
        $purchase->load('items');
        return $purchase;
    }


    /**
     * Update a invoice by UUID.
     *
     * @param string $uuid The UUID of the invoice.
     * @param array<mixed> $data The data to update the invoice with.
     * @return \App\Models\Purchase The updated invoice.
     */
    public function update(string $uuid, array $data)
    {
        $purchase = $this->findByUuid($uuid);
        $purchase->update($data);
        return $purchase;
    }


    /**
     * Deletes a invoice by its UUID.
     *
     * @param string $uuid The UUID of the invoice to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the invoice.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting invoice with UUID: ' . $uuid);
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();
        $purchase->delete();
    }

    /**
     * Finds an invoice by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the invoice is not found.
     * @return \App\Models\Purchase The found invoice.
     */
    public function find(string $uuid)
    {
        return Purchase::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a invoice by its UUID.
     *
     * @param mixed $uuid The UUID of the invoice.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no invoice is found.
     * @return Purchase The Purchase model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Purchase::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Purchase::all();
    }

    /**
     * Paginate the results of the query.
     *
     * @param int $perPage The number of items per page.
     * @throws Some_Exception_Class Description of exception.
     * @return \Illuminate\Purchases\Pagination\Paginator The paginated results.
     */
    public function paginate(?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Purchase::paginate($perPage);
    }

    /**
     * Finds and paginates products by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Purchases\Pagination\LengthAwarePaginator The paginated products.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Purchase::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
