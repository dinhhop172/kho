<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all users.
     *
     * @return User $user
     */
    public function getAll()
    {
        // return $this->user
        //     ->get();
        return $this->user->orderBy('id', 'DESC')->paginate(5);
    }

    /**
     * getById
     *
     * @param  mixed $id
     * @return void
     */
    public function getById($id)
    {
        return $this->user
            ->where('id', $id)
            ->get();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * save
     *
     * @param  mixed $data
     * @return void
     */
    public function save($data)
    {
        return $this->user->create($data);
    }

    /**
     * update
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function update($data, $id)
    {
        $result = $this->user->findOrFail($id);
        if ($result) {
            $result->update($data);
            return $result;
        }

        return false;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {

        $user = $this->user->find($id);
        $user->delete();

        return $user;
    }
    /**
     * search
     *
     * @param  mixed $name
     * @return void
     */
    public function search($name)
    {
        return $this->user->where('name', 'like', '%'.$name.'%')->latest('id')->paginate(5);
    }
}
