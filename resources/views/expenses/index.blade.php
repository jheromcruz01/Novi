@extends('layout.layout')
@section('expenses','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Expenses</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Expenses</li>
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
                <i class="fas fa-plus mr-1"></i>Add Expenses
            </button>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table id="datatable" class="table" style="width: 100%; height: 100%">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
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
            <label for="" class="col-sm-3 col-form-label">Item</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="item" id="item" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Qty</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="qty" name="qty" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Price</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
        </div>

        <input type="hidden" id="id" name="id">
    </form>
@endsection

@section('javascript')
    <script src="{{asset('javascript/expenses.js')}}"></script>
@endsection