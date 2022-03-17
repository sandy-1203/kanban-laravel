<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{

    const MODEL_LABEL = 'User';

    public function __construct(
        User $model
    ) {
        parent::__construct($model);
    }

    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        return parent::create($data);
    }

    public function findByEmail($email)
    {
        return $this->findOne([['email', $email]]);
    }

    public function findByEmailOrFail($email)
    {
        $user = $this->findOne([['email', $email]]);
        if (!$user) throw new ModelNotFoundException($this->getModelLabel() . " $email not found!.");
        return $user;
    }
}
