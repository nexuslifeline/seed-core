<?php

namespace App\Repositories;

interface InvoiceSettingRepositoryInterface
{
    public function updateOrCreate(array $criteria, array $data);
}
