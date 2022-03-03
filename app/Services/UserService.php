<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
    
    public function getCreate($data)
    {
        $result = $this->userRepository->save($data);
        return $result;
    }

    
    public function getUpdate($request, $id)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = $this->userRepository->update($data, $id);
        return $user;
    }
    public function getDestroy($id)
    {
        $user = $this->userRepository->delete($id);
        return $user;
    }

    public function getUser($name)
    {
        return $this->userRepository->search($name);
    }

    
}