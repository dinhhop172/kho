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
     * save
     *
     * @param  mixed $data
     * @return void
     */
    public function save($data)
    {
        try {
            DB::beginTransaction();
            $role = $this->role->create($data);
            if (!empty(request()->permission)) {
                foreach(request()->permission as $item) {
                    $perInstance = $this->permission->firstOrCreate(['name' => $item, 'slug' => Str::slug($item)]);
                    $perIds[] = $perInstance->id;
                }
                $role->permissions()->attach($perIds);
            }
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new Exception('Error Processing Request');
        }

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
        try {
            DB::beginTransaction();
            $this->role->findOrFail($id)->update($data);
            $role = $this->role->findOrFail($id);
            if (!empty(request()->permission)) {
                foreach(request()->permission as $item) {
                    $perInstance = $this->permission->firstOrCreate(['name' => $item, 'slug' => Str::slug($item)]);
                    $perIds[] = $perInstance->id;
                }
                $role->permissions()->sync($perIds);
            }
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new Exception('Error Processing Request');
        }

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
