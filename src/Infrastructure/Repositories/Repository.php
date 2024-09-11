<?php

namespace Infrastructure\Repositories;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection ;

abstract class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly Builder $query,
        private readonly DatabaseManager $database
    )
    {
        
    }
	public function all(): Collection
	{
        return   $this->query->get();
	}

	public function find(string $id,array $with = []): ?object
	{
		return $this->query->with($with)->findOrFail($id);
	}

	public function create(object $entity):object
	{
		return $this->database->transaction(
            callback: function () use ($entity) {
                return $this->query->create($entity->toArray());
            },
            attempts: 3
        );
	}

	public function update($id, object $entity):object
	{
        return $this->database->transaction(
            callback: function () use ($entity,$id) {
                return $this->query->where('id','=',$id)->update($entity->toArray());
            },
            attempts: 3
        );
	}

	public function delete(string $id):void
	{
		$this->database->transaction(
            callback: function () use ($id) {
                return $this->query->where('id','=',$id)->delete();
            },
            attempts: 3
        );
	}
}
