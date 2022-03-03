<?php

namespace App\Repositories;

use App\Models\User;

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

    public function getById($id)
    {
        return $this->user
            ->where('id', $id)
            ->get();
    }
    public function save($data)
    {
        $user = new $this->user;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        $user->save();

        return $user->fresh();
    }

    public function update($data, $id)
    {
        
        $user = $this->user->find($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        $user->update();

        return $user;
    }

    public function delete($id)
    {
        
        $user = $this->user->find($id);
        $user->delete();

        return $user;
    }
    public function search($name)
    {
        return $this->user->where('name', 'like', '%'.$name.'%')->latest('id')->paginate(5);
    }
}