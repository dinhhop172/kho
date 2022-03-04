<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class RoleService
{
    /**
     * @var $roleRepository
     */
    protected $roleRepository;

    /**
     * permission
     *
     * @var mixed
     */
    protected $permission;

    /**
     * RoleService constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository, Permission $permission)
    {
        $this->roleRepository = $roleRepository;
        $this->permission = $permission;
    }


    /**
     * Get all role.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function getById($id)
    {
        return $this->roleRepository->getById($id);
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['slug'] = Str::slug($data['name']);
            $role = $this->roleRepository->save($data);
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


    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['slug'] = Str::slug($data['name']);
            $this->roleRepository->update($data, $id);
            $role = $this->roleRepository->findOrFail($id);
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

    public function destroy($id)
    {
        $role = $this->roleRepository->delete($id);
        return $role;
    }

    public function getRole($name)
    {
        return $this->roleRepository->search($name);
    }
}
