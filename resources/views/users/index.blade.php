@extends('layout.layout')
@section('user','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <button class="btn btn-primary float-right" onclick="userModal(0)" style="margin:-5px">
                <i class="fas fa-plus mr-1"></i>Add User
            </button>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table id="datatable" class="table" style="width: 100%; height: 100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('modal-width')
<div class="modal-dialog" role="document" style="max-width: 600px">
@endsection

@section('modal-title')
    <h3 id="modal-title" class="modal-title" style="font-weight: normal"></h3>
@endsection

@section('modal-content')
    <form id="form" class="p-2">
        @csrf
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="firstname" id="firstname" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Middle Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="middlename" name="middlename">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Roles</label>
            <div class="col-sm-9">
                <select class="select2-primary" id="roles" name="roles" data-placeholder="Select Roles" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                    <option value="1">Admin</option>
                    <option value="0">User</option>
                </select>
            </div>
        </div>

        <input type="hidden" id="id" name="id">
    </form>
@endsection

@section('javascript')
    <script src="{{asset('javascript/user.js')}}"></script>
@endsection