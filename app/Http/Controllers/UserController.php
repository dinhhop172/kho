<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->getAll();
        return view('users.index' , ['data' => $data]);
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);

        return view('users.show' , ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users/create', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->save($request);
        return redirect(route('users.index'));
    }
    
    public function edit($id)
    {
        $user = $this->userService->getById($id);
        return view('users.edit' , compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->getUpdate($request, $id);
        return redirect(route('users.index'));
    }

    public function destroy($id)
    {
        $this->userService->getDestroy($id);
        return redirect(route('users.index'));
    }

    public function search(Request $request)
    {
        $data = $this->userService->getUser($request->search);
        return view('users.index', compact('data'));
    }


}
