<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

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
        // auth()->user()->givePermissionTo('edit articles', 'delete articles', 'create articles');
        // $user->assignRole('writer');
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
        return view('users/create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $this->userService->getCreate($request);
        return redirect(route('users.index'));
    }
    public function edit($id)
    {
        $user = $this->userService->getById($id);

        return view('users.edit' , compact('user'));
    }
    public function update(UpdateUserRequest $request, $id)
    {
        // $data = $request->all();
        // $data['password'] = Hash::make($request->password);
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
