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
        <div class="container">
            <!-- Display the chart -->
            <canvas id="expensesChart" width="400" height="100"></canvas>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Expenses</h5>
                            <p class="card-text">₱{{ number_format($totalExpenses, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text">₱{{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Income</h5>
                            <p class="card-text">₱{{ number_format($income, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Get the data from PHP
            var totalSales = {!! json_encode($totalSales) !!};
            var totalExpenses = {!! json_encode($totalExpenses) !!};
            var income = {!! json_encode($income) !!};

            // Ensure the DOM is ready and the chart is rendered
            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById('expensesChart').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'bar', // Bar chart
                    data: {
                        labels: ['Total Expenses', 'Total Sales', 'Income'],  // Labels for the bars
                        datasets: [{
                            label: 'Amount (in PHP)',
                            data: [totalExpenses, totalSales, income],  // Data points
                            backgroundColor: ['#dc3545', '#28a745', '#ffc107'],  // Color for each bar
                            borderColor: ['#dc3545', '#28a745', '#ffc107'],  // Border color for each bar
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,  // Start the Y-axis from 0
                                ticks: {
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString();  // Format the Y-axis values as currency
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>

    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{asset('javascript/home.js')}}"></script>
@endsection