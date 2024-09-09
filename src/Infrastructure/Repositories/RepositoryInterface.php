<?php

namespace Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
/**
 * @property-read DatabaseManager $database
 * @property-read Builder $query
 */
interface RepositoryInterface
{
    public function all(): Collection;
    public function find(string $id,array $with = []): ?object;
    public function create(object $entity): object;
    public function update(string $id, object $entity): object;
    public function delete(string $id): void;
}
