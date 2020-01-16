@extends('layouts.backend.master')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $applications_count }}</h3>

                        <p>APPLICATIONS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $approved_applications_count }}</h3>

                        <p>APPROVE APPLICATION</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $products_count }}</h3>

                        <p>PRODUCTS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>&#8369;{{ number_format($summary['total_due']) }}</h3>

                        <p>TOTAL DUE (dapat bayaran)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Analytics - Approved Loans</h3>
                    </div>
                    <div class="card-body">
                        <div class="canvas">
                            <canvas id="chartjs-1" class="chart" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applications</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Brand</th>
                                        <th>Down Payment</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($applications)
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ ucwords($application->user->full_name) }}</td>
                                        <td>{{ $application->product->title }}</td>
                                        <td>{{ $application->product->product_brand }}</td>
                                        <td>&#8369;{{ number_format($application->down_payment) }}</td>
                                        <td>{{ date('F j, Y g:i a', strtotime($application->created_at)) . ' | ' . $application->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{ url('/admin/application/view/'.$application->id) }}" class="btn btn-primary btn-sm">view</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <div class="alert alert-warning">
                                        <strong>No data.</strong>
                                    </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Due</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer_scripts')

<script src="{{ URL::asset('assets/plugins/chartjs/dist/Chart.bundle.min.js') }}"></script>
<script>

function format_number(n) {
    return n.toFixed(0).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

$(document).ready(function($) {
    var ctx_year = document.getElementById('chartjs-1').getContext('2d');
     new Chart(ctx_year, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            "labels":["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "datasets":[
                {
                    "label":"Total amount",
                    "data":{!! $data['arrTotalsAmount_year1'] !!},
                    "fill":false,
                    "backgroundColor":[
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                    "rgba(255, 205, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(201, 203, 207, 0.2)",
                    "rgba(181, 147, 50, 0.2)",
                    "rgba(232, 130, 81, 0.2)",
                    ],
                    "borderColor":[
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(255, 99, 132)",
                    "rgb(255, 159, 64)",
                    "rgb(255, 205, 86)",
                    "rgb(75, 192, 192)",
                    "rgb(54, 162, 235)",
                    "rgb(153, 102, 255)",
                    "rgb(201, 203, 207)",
                    "rgb(181, 147, 50)",
                    "rgb(232, 130, 81)",
                    ],
                    "borderWidth":1,
                    type:"bar",
                },
                {
                    "label":"Line total amount",
                    "data":{!! $data['arrTotalsAmount_year1'] !!},
                    "fill":false,
                    "backgroundColor":"blue",
                    "borderColor":"blue",
                    "borderWidth":1,
                    type:"line",
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
              display: true,
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 0,
                    bottom: 0
                }
            },

            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += format_number(tooltipItem.yLabel);
                        return label;
                    }
                }
            },
            scales: {
                yAxes: [
                {
                  position: "left",
                  // id: "y-axis-amount",
                  ticks: {
                        beginAtZero:true,
                        callback: function(label, index, labels) {
                            return format_number(label);
                        },
                    },
                    scaleLabel: {
                         display: true,
                         labelString: 'Bit',
                         fontSize: 15
                      }
                }
                ]
            },
        },

    });
    });
</script>
@stop