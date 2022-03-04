<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UserService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;
    protected $role;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, Role $role)
    {
        $this->userRepository = $userRepository;
        $this->role = $role;
    }


    /**
     * Get all user.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function save($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->save($data);
            if(!empty(request()->roles)){
                foreach(request()->roles as $item){
                    $roleInstance = $this->role->firstOrCreate(['name' => $item, 'slug' => Str::slug($item)]);
                    $perIds[] = $roleInstance->id;
                }
                $user->roles()->attach($perIds);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new Exception('Error Processing Request');
        }
    }

    public function getUpdate($request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $this->userRepository->update($data, $id);
            $user = $this->userRepository->findOrFail($id);
            if (!empty(request()->roles)) {
                foreach(request()->roles as $item) {
                    $roleInstance = $this->role->firstOrCreate(['name' => $item, 'slug' => Str::slug($item)]);
                    $roleIds[] = $roleInstance->id;
                }
                $user->roles()->sync($roleIds);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new Exception('Error Processing Request');
        }

    }
    public function getDestroy($id)
    {
        return $this->userRepository->delete($id);
    }

    public function getUser($name)
    {
        return $this->userRepository->search($name);
    }


}
