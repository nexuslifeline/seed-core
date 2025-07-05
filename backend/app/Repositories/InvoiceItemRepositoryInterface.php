<?php

namespace App\Repositories;

use App\Models\InvoiceItem;

interface InvoiceItemRepositoryInterface
{
    public function create(array $data);

    public function update(InvoiceItem $invoiceItem, array $data);

    public function delete(InvoiceItem $invoiceItem);

    public function find($id);

    public function all();
}
