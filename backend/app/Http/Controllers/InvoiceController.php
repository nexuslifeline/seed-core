<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Http\Resources\InvoiceResource;
use App\Repositories\InvoiceItemRepositoryInterface;
use App\Repositories\InvoiceRepositoryInterface;
use App\Utils\ErrorMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    private $invoiceRepository;
    private $invoiceItemRepository;

    /**
     * Constructs a new instance of the class.
     *
     * @param InvoiceRepositoryInterface $invoiceRepository The invoice repository.
     */
    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceItemRepositoryInterface $invoiceItemRepository
    ) {
        // Set the invoice repository
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    /**
     * Retrieves a paginated collection of invoice resources.
     *
     * @param Request $request The HTTP request object.
     * @throws \Exception If an error occurs during the invoice list fetch.
     * @return \App\Http\Resources\InvoiceResource A collection of invoice resources.
     */
    public function index(Request $request, string $orgUuid)
    {
        try {
            // Retrieve the per_page parameter from the request
            $perPage = $request->input('per_page');
            // Retrieve the invoices from the repository
            $invoices = $this->invoiceRepository->findByOrgUuidAndPaginate($orgUuid, $perPage);
            // Return a collection of invoice resources
            return InvoiceResource::collection($invoices);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during invoice list fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retrieve and show a invoice by its UUID.
     *
     * @param string $uuid The UUID of the invoice.
     * @throws \Exception If there is an error during invoice fetch.
     * @return InvoiceResource The resource representing the invoice.
     */
    public function show(string $orgUuid, string $uuid)
    {
        try {
            // Retrieve the invoice from the repository
            $invoice = $this->invoiceRepository->findByUuid($uuid);
            // Return the invoice resource
            return new InvoiceResource($invoice);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during invoice fetch. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new invoice.
     *
     * @param InvoiceStoreRequest $request The request object containing the invoice data.
     * @throws \Exception If an error occurs during the invoice creation.
     * @return InvoiceResource The resource representing the created invoice.
     */
    public function store(InvoiceStoreRequest $request)
    {
        // Log::info($request->all());
        // Log::info("Invoice creation request received.");
        try {
            // Validate the request and retrieve the data
            $data = $request->except('validate');
            // Create the invoice
            $invoice = $this->invoiceRepository->create($data);

            // Return the invoice resource
            return new InvoiceResource($invoice);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during invoice creation. " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a invoice.
     *
     * @param InvoiceUpdateRequest $request The request object containing the updated invoice data.
     * @param string $uuid The UUID of the invoice to be updated.
     * @throws ModelNotFoundException If the invoice with the given UUID does not exist.
     * @return InvoiceResource The updated invoice resource.
     */
    public function update(InvoiceUpdateRequest $request, string $orgUuid, string $uuid)
    {
        try {
            // Validate the request and retrieve the data
            $data = $request->all();

            // Update the invoice
            $invoice = $this->invoiceRepository->update($uuid, $data);

            // Return the invoice resource
            return new InvoiceResource($invoice);
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND . $uuid . $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during invoice update. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a invoice.
     *
     * @param string $uuid The UUID of the invoice to be deleted.
     * @throws \Exception If there is an error during the invoice deletion.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message.
     */
    public function destroy(string $orgUuid, string $uuid)
    {
        try {
            // Delete the invoice
            $this->invoiceRepository->delete($uuid);
            // no content response
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            // Resource not found
            return response()->json(['error' => ErrorMessages::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Something went wrong
            Log::error("Error during invoice deletion. " . $e->getMessage());
            return response()->json(['error' => ErrorMessages::SOMETHING_WENT_WRONG . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
