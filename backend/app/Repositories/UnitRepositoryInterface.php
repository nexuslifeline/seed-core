<?php

namespace App\Repositories;

interface UnitRepositoryInterface
{
    public function create(array $data);

    public function update(string $uuid, array $data);

    public function delete(string $uuid);

    public function find(string $uuid);

    public function findByUuid(string $uuid);

    public function all();

    public function paginate(int $perPage);

    public function findByOrgUuidAndPaginate(string $orgUuid, ?int $perPage);
}
