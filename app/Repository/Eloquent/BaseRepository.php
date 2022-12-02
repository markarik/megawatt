<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements EloquentRepositoryInterface {

	protected $model;

	function __construct(Model $model){
		$this->model = $model;
	}

	/**
	 * @return Collection
	 */	
	public function all(): Collection
	{
		return $this->model->all();
	}

	/**
	 * @param array $data
	 * @return Model
	 */
	public function create(array $data): Model
	{
		return $this->model->create($data);
	}

	/**
	 * @param $id
	 * @return Model
	 */
	public function find($id): ?Model
	{
		return $this->model->find($id);
	}

	/**
	 * @param $id
	 * @param $data
	 * @return Model
	 */
	public function update($id, $data): ?Model
	{
		$model = $this->find($id);
		if( $model ){
			$model->update($data)->refresh();
			return $model;
		}
		return null;
	}

}
