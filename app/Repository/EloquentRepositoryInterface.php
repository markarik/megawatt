<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface EloquentRepositoryInterface {
	
	/**
	 * @return Collection
	 */
	public function all(): Collection;
	
	/**
	 * @param array $data
	 * @return Model
	 */
	public function create(array $data): Model;
	
	/**
	 * @param $id
	 * @return Model
	 */
	public function find($id): ?Model;

	/**
	 * @param $id
	 * @param $data
	 * @return Model
	 */
	public function update($id, $data): ?Model;
	
}
