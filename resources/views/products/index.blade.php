@extends('layout.layout')
@section('products','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
                <i class="fas fa-plus mr-1"></i>Add Product
            </button>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table id="datatable" class="table" style="width: 100%; height: 100%">
                <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Miners</th>
                    <th>Sold To</th>
                    <th>Sold Price</th>
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
            <label for="" class="col-sm-3 col-form-label">Item Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="item_code" id="item_code" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Color</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="color" name="color">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Size</label>
            <div class="col-sm-9">
                <select class="select2-primary" id="size" name="size" data-placeholder="Select Sizes" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                    <option value="XS">XS</option>
                    <option value="XS-S">XS-S</option>
                    <option value="S">S</option>
                    <option value="S-M">S-M</option>
                    <option value="M">M</option>
                    <option value="M-L">M-L</option>
                    <option value="L">L</option>
                    <option value="L-XL">L-XL</option>
                    <option value="XL">XL</option>
                    <option value="XL-XXL">XL-XXL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
                <select class="select2-primary" id="status" name="status" data-placeholder="Select Status" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                    <option value="Available">Available</option>
                    <option value="Mine">Mine</option>
                    <option value="Lock">Lock</option>
                    <option value="Paid">Paid</option>
                    <option value="Ship">Ship</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Miner</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="miner" name="miner">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Sold to</label>
            <div class="col-sm-9">
                <select class="select2-primary" id="customer_id" name="customer_id" data-placeholder="Select Customer" data-dropdown-css-class="select2-primary" style="width: 100%;">
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Sold Price</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="price" name="price">
            </div>
        </div>

        <input type="hidden" id="id" name="id">
    </form>
@endsection

@section('javascript')
    <script src="{{asset('javascript/products.js')}}"></script>
@endsection