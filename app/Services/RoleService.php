<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class RoleService
{
    /**
     * @var $roleRepository
     */
    protected $roleRepository;

    /**
     * RoleService constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
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

    public function getCreate($data)
    {
        $result = $this->roleRepository->save($data);
        return $result;
    }


    public function getUpdate($data, $id)
    {
        $role = $this->roleRepository->update($data, $id);
        return $role;
    }
    public function getDestroy($id)
    {
        $role = $this->roleRepository->delete($id);
        return $role;
    }

    public function getRole($name)
    {
        return $this->roleRepository->search($name);
    }


}
