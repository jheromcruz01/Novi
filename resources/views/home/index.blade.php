@extends('layout.layout')
@section('users','active')
@section('content')

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Home</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Default box -->
    <div class="card">
    
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{asset('javascript/home.js')}}"></script>
@endsection