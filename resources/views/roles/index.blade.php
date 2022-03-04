@extends('layouts.dashboard')

@section('sibar')
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <b class="navbar-brand m-0">
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">Book Management</span>
    </b>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('home') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="{{ route('users.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Manage Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white active bg-gradient-primary" href="{{ route('roles.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Manage Role</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="{{ route('categories.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Manage Category</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="../pages/virtual-reality.html">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">view_in_ar</i>
          </div>
          <span class="nav-link-text ms-1">Virtual Reality</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="../pages/rtl.html">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
          </div>
          <span class="nav-link-text ms-1">RTL</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="../pages/notifications.html">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">notifications</i>
          </div>
          <span class="nav-link-text ms-1">Notifications</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="../pages/profile.html">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer position-absolute w-100 bottom-0 ">
    <div class="mx-3">
      <a class="btn bg-gradient-primary mt-4 w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
    </div>
  </div>
</aside>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Roles Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
            <form action="{{route('roles.search')}}" method="get">
              <input type="text" name="search" placeholder="search name...">
            </form>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>Id</th>
   <th>Name</th>
   <th>Permission</th>
   <th>Action</th>
 </tr>
 @foreach ($data as $key => $role)
  <tr>
    <td>{{ $role->id }}</td>
    <td>{{ $role->name }}</td>
    <td>
        @if(!empty($role->permissions))
            @foreach($role->permissions as $v)
            <label class="badge badge-success">{{ $v->name }},</label>
            @endforeach
        @endif
    </td>

    <td>
        {{-- <a class="btn btn-info" href="{{route('users.show', ['id' => $user->id])}}">Show</a> --}}
        <a class="btn btn-info" href="{{ route('roles.edit', $role->id)}}">Edit</a>
        <a class="btn btn-danger" href="{{ route('roles.destroy', $role->id)}}">Delete</a>
     </td>
  </tr>
 @endforeach
</table>


<div class="col-12">
    <div class='pagination-container'>
        {!! $data->links() !!}
    </div>

</div>
@endsection
