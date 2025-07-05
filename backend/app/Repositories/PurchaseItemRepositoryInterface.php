<?php

namespace App\Repositories;

use App\Models\PurchaseItem;

interface PurchaseItemRepositoryInterface
{
    public function create(array $data);

    public function update(PurchaseItem $purchaseItem, array $data);

    public function delete(PurchaseItem $purchaseItem);

    public function find($id);

    public function all();
}
