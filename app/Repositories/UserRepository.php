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
     * role
     *
     * @var mixed
     */
    protected $role;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
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
     * save
     *
     * @param  mixed $data
     * @return void
     */
    public function save($data)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->create($data);
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
            $this->user->findOrFail($id)->update($data);
            $user = $this->user->findOrFail($id);
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
