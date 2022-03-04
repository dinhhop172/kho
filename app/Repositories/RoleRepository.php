<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoleRepository
{
    /**
     * @var Role
     */
    protected $role;
    protected $permission;

    /**
     * RoleRepository constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Get all roles.
     *
     * @return Role $role
     */
    public function getAll()
    {
        // return $this->role
        //     ->get();
        return $this->role->orderBy('id', 'DESC')->paginate(5);
    }

    /**
     * getById
     *
     * @param  mixed $id
     * @return void
     */
    public function getById($id)
    {
        return $this->role
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
        return $this->role->findOrFail($id);
    }

    /**
     * save
     *
     * @param  mixed $data
     * @return void
     */
    public function save($request)
    {
        return $this->role->create($request);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update($request, $id)
    {
        $result = $this->role->findOrFail($id);
        if ($result) {
            $result->update($request);
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

        $role = $this->role->find($id);
        $role->delete();

        return $role;
    }
    /**
     * search
     *
     * @param  mixed $name
     * @return void
     */
    public function search($name)
    {
        return $this->role->where('name', 'like', '%'.$name.'%')->latest('id')->paginate(5);
    }
}
