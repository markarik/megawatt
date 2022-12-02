<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	/**
	 * UserRepository constructor.
	 *
	 * @param User $model
	 */
	public function __construct(User $model){
		parent::__construct($model);
	}
	
}
