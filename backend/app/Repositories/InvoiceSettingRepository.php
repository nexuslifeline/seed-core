<?php

namespace App\Repositories;

use App\Models\InvoiceSetting;

class InvoiceSettingRepository implements InvoiceSettingRepositoryInterface
{

    /**
     * Update or create a record in the database based on the given criteria and data.
     *
     * @param array $criteria The criteria to search for the record.
     * @param array $data The data to be updated or created.
     * @return InvoiceSetting The updated or created invoice setting.
     */
    public function updateOrCreate(array $criteria, array $data)
    {
        $invoiceSetting = InvoiceSetting::updateOrCreate($criteria, $data);
        return $invoiceSetting;
    }
}
