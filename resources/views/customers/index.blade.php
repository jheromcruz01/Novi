@extends('layout.layout')
@section('customers','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Customers</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="datatable" class="table" style="width: 100%; height: 100%">
                <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Username</th>
                    <th>Full Namme</th>
                    <th>Contact Number</th>
                    <th>Shipping Address</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Barangay</th>
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


@section('javascript')
    <script src="{{asset('javascript/customers.js')}}"></script>
@endsection