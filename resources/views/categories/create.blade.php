@extends('layouts.dashboard')

@section('sibar')
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <b class="navbar-brand m-0">
      <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
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
            <h2>Create New Category</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>


@if ($errors->any())
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif


<div class="container mt-4">
  <form method="POST" action="{{route('categories.store')}}">
      @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Category name</strong>
            <input type="text" name="name" class="form-control" placeholder="Name">
        </div>
        <div class="form-group">
          <strong>Select parent category</strong>
          <select class="form-control" name="parent_id">
            <option value="">None</option>
            @if($categories)
            @php
                $space = "";
            @endphp
                @foreach($categories as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @if(count($value->children) > 0)
                        @include('categories.children',['children' => $value->children])
                    @endif
                @endforeach
            @endif
          </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
@endsection
