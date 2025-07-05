<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Utils\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Creates a new Payment record in the database.
     *
     * @param array $data The data for creating the Payment record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Payment The newly created Payment record.
     */
    public function create(array $data)
    {

        DB::beginTransaction();
        $payment = Payment::create($data);

        $invoices = $data['invoices'] ?? [];

        $tempInvoices = [];
        // Save related payment invoices
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $tempInvoices[$invoice['invoice_id']] = [
                    'line_total' => $invoice['line_total'],
                    'notes' => $invoice['notes']
                ];
            }
        }

        $payment->paymentInvoices()->sync($tempInvoices);

        DB::commit();
        $payment->load('paymentInvoices');
        return $payment;
    }


    /**
     * Update a payment by UUID.
     *
     * @param string $uuid The UUID of the payment.
     * @param array<mixed> $data The data to update the payment with.
     * @return \App\Models\Payment The updated payment.
     */
    public function update(string $uuid, array $data)
    {

        DB::beginTransaction();
        $payment = $this->findByUuid($uuid);

        $payment->update($data);
        $invoices = $data['invoices'] ?? [];

        $tempInvoices = [];
        // Save related payment invoices
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $tempInvoices[$invoice['invoice_id']] = [
                    'line_total' => $invoice['line_total'],
                    'notes' => $invoice['notes']
                ];
            }
        }

        $payment->paymentInvoices()->sync($tempInvoices);

        DB::commit();
        $payment->load('paymentInvoices');
        return $payment;

    }


    /**
     * Deletes a payment by its UUID.
     *
     * @param string $uuid The UUID of the payment to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the payment.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting payment with UUID: ' . $uuid);
        $payment = Payment::where('uuid', $uuid)->firstOrFail();
        $payment->delete();
    }

    /**
     * Finds an payment by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the payment is not found.
     * @return \App\Models\Payment The found payment.
     */
    public function find(string $uuid)
    {
        return Payment::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a payment by its UUID.
     *
     * @param mixed $uuid The UUID of the payment.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no payment is found.
     * @return Payment The Payment model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Payment::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Payment::all();
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
        return Payment::paginate($perPage);
    }

    /**
     * Finds and paginates payments by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated payments.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE)
    {
        return Payment::whereHas('organization', function ($q) use ($orgUuid) {
            $q->where('uuid', $orgUuid);
        })->paginate($perPage);
    }
}
