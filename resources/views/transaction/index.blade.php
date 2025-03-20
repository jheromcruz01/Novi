@extends('layout.layout')
@section('transactions','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Transactions</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
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
                <i class="fas fa-plus mr-1"></i>Create transaction
            </button>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
        <div class="filter-section row">
                <div class="col-md-6">
                    <label for="status-filter">Status:</label>
                    <select id="status-filter" class="form-control">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>
            </div>
            <br>
            <table id="datatable" class="table" style="width: 100%; height: 100%">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Item/s</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Date</th>
                    <th>Shipping Fee</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted here dynamically -->
                </tbody>
                <tfoot>
                    <!-- Total price row will be appended here dynamically -->
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('modal-width')
<div class="modal-dialog" role="document" style="max-width: 800px">
@endsection

@section('modal-title')
    <h3 id="modal-title" class="modal-title" style="font-weight: normal"></h3>
@endsection

@section('modal-content')
    <form id="form" class="p-2">
        @csrf
        <div id="product-selection-container">
            <div class="form-group row product-selection" id="product-selection-1">
                <label for="product_id_1" class="col-md-1 col-form-label">Product</label>
                <div class="col-md-4">
                    <select class="select2-primary product-select" id="product_id_1" name="product_id[]" style="width: 100%;" required>
                        <option value="" disabled selected>Select Product</option>
                        <!-- Product options will be dynamically added here -->
                    </select>
                </div>
                <br><br>
                <label for="price_type_1" class="col-md-1 col-form-label">Price</label>
                <div class="col-md-4">
                    <select class="form-control" id="price_type_1" name="price_type[]" required>
                        <option value="" disabled selected>Select Price Type</option>
                        <!-- Price options will be dynamically added here -->
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-product-btn mt-1" onclick="removeProduct(1)">Remove</button>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mb-2 mr-3">
            <button type="button" class="btn btn-primary btn-sm mr-4" onclick="addProduct()">Add More</button>
        </div>
        <!-- Add More Product Button -->
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Customer</label>
            <div class="col-sm-9">
                <select class="select2-primary" id="customer_id" name="customer_id" data-placeholder="Select Customer" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Shipping Fee</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="shipping_fee" name="shipping_fee" required>
            </div>
        </div>

        <input type="hidden" id="id" name="id">
    </form>
@endsection

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    <input type="hidden" id="orderId">
                    <div class="mb-3">
                        <label for="orderStatus" class="form-label">Order Status</label>
                        <select class="form-control" id="orderStatus" required>
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


@section('javascript')
    <script src="{{asset('javascript/transaction.js')}}"></script>
@endsection