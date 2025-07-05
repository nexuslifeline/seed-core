<?php

namespace App\Repositories;

use App\Models\Category;
use App\Utils\Constants;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Creates a new Category record in the database.
     *
     * @param array $data The data for creating the Category record.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Category The newly created Category record.
     */
    public function create(array $data)
    {
        return Category::create($data);
    }


    /**
     * Update a category by UUID.
     *
     * @param string $uuid The UUID of the category.
     * @param array<mixed> $data The data to update the category with.
     * @return \App\Models\Category The updated category.
     */
    public function update(string $uuid, array $data)
    {
        $category = $this->findByUuid($uuid);
        $category->update($data);
        return $category;
    }


    /**
     * Deletes a category by its UUID.
     *
     * @param string $uuid The UUID of the category to be deleted.
     * @throws Some_Exception_Class If an error occurs while deleting the category.
     * @return void
     */
    public function delete(string $uuid)
    {
        Log::info('Deleting category with UUID: ' . $uuid);
        $category = Category::where('uuid', $uuid)->firstOrFail();
        $category->delete();
    }

    /**
     * Finds an category by ID.
     *
     * @param int $id The ID of the admin to find.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the category is not found.
     * @return \App\Models\Category The found category.
     */
    public function find(string $uuid)
    {
        return Category::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Finds a category by its UUID.
     *
     * @param mixed $uuid The UUID of the category.
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If no category is found.
     * @return Category The Category model instance.
     */
    public function findByUuid(string $uuid)
    {
        return Category::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Retrieves all records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Category::all();
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
        return Category::paginate($perPage);
    }

    /**
     * Finds and paginates products by organization UUID.
     *
     * @param string $orgUuid The UUID of the organization.
     * @param int|null $perPage The number of items per page. Default is 25.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated products.
     */
    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage = Constants::DEFAULT_PER_PAGE, ?string $search)
    {
        return Category::whereHas('organization', function ($q) use ($orgUuid, $search) {
            $q->where('uuid', $orgUuid);
        })->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
        })->paginate($perPage);
    }
}
