<?php

namespace App\Repositories;

use App\Models\PurchaseItem;

class PurchaseItemRepository implements PurchaseItemRepositoryInterface
{
    /**
     * Creates a new PurchaseItem record in the database.
     *
     * @param array $data The data for creating the PurchaseItem record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return PurchaseItem The newly created PurchaseItem record.
     */
    public function create(array $data)
    {
        return PurchaseItem::create($data);
    }

    /**
     * Updates an PurchaseItem with the given data.
     *
     * @param PurchaseItem $purchaseItem The PurchaseItem to update.
     * @param array $data The data to update the PurchaseItem with.
     * @return PurchaseItem The updated PurchaseItem.
     */
    public function update(PurchaseItem $purchaseItem, array $data)
    {
        $purchaseItem->update($data);
        return $purchaseItem;
    }

    /**
     * Deletes an purchaseItem.
     *
     * @param PurchaseItem $purchaseItem The purchaseItem to delete.
     * @throws Some_Exception_Class When an error occurs while deleting the purchaseItem.
     */
    public function delete(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();
    }

    /**
     * Finds an purchaseItem by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the purchaseItem is not found.
     * @return \App\Models\PurchaseItem The found purchaseItem.
     */
    public function find($id)
    {
        return PurchaseItem::findOrFail($id);
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return PurchaseItem::all();
    }
}
