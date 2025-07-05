<?php

namespace App\Repositories;

use App\Models\InvoiceItem;

class InvoiceItemRepository implements InvoiceItemRepositoryInterface
{
    /**
     * Creates a new InvoiceItem record in the database.
     *
     * @param array $data The data for creating the InvoiceItem record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return InvoiceItem The newly created InvoiceItem record.
     */
    public function create(array $data)
    {
        return InvoiceItem::create($data);
    }

    /**
     * Updates an InvoiceItem with the given data.
     *
     * @param InvoiceItem $invoiceItem The InvoiceItem to update.
     * @param array $data The data to update the InvoiceItem with.
     * @return InvoiceItem The updated InvoiceItem.
     */
    public function update(InvoiceItem $invoiceItem, array $data)
    {
        $invoiceItem->update($data);
        return $invoiceItem;
    }

    /**
     * Deletes an invoiceItem.
     *
     * @param InvoiceItem $invoiceItem The invoiceItem to delete.
     * @throws Some_Exception_Class When an error occurs while deleting the invoiceItem.
     */
    public function delete(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();
    }

    /**
     * Finds an invoiceItem by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the invoiceItem is not found.
     * @return \App\Models\InvoiceItem The found invoiceItem.
     */
    public function find($id)
    {
        return InvoiceItem::findOrFail($id);
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return InvoiceItem::all();
    }
}
