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

    public function getById($id)
    {
        return $this->role
            ->where('id', $id)
            ->get();
    }
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

    public function delete($id)
    {

        $role = $this->role->find($id);
        // $role->permissions()->detach();
        $role->delete();

        return $role;
    }
    public function search($name)
    {
        return $this->role->where('name', 'like', '%'.$name.'%')->latest('id')->paginate(5);
    }
}
