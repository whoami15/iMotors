@extends('layouts.backend.master')

@section('title', 'Payment History')

@section('header_scripts')
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<style>
    .table-responsive {
        font-size:18px!important;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Payment History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payment History</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content" ng-app="applicationApp" ng-controller="ApplicationCtrl as frm">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment History</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="loading">
                            <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
                        </div>
                        <table id="content-table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer_scripts')
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="{{ URL::asset('assets/plugins/angular/angular.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/ui-bootstrap/ui-bootstrap.min.js')  }}"></script>

<script type="text/javascript">
    (function () {
        var applicationApp = angular.module('applicationApp', ['angular.filter']);
        applicationApp.controller('ApplicationCtrl', function ($scope, $http, $sce) {

            var vm = this;

            getdata();
            function getdata() {

                $("#content-table").dataTable().fnDestroy(); 
                $('#loading').show();
                $("#content-table").hide();
                
                angular.element(document).ready( function () {

                    var tbl = $('#content-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/admin/member-payments-history-data',
                            data: function (data) {

                                for (var i = 0, len = data.columns.length; i < len; i++) {
                                    if (! data.columns[i].search.value) delete data.columns[i].search;
                                    if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                                    if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                                    if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                                }
                                delete data.search.regex;

                            }
                        },
                        lengthChange: false,
                        info: false,
                        autoWidth: false,
                        columnDefs: [
                            {
                                render: function (data, type, full, meta) {
                                    return "<div>" + data + "</div>";
                                },
                                targets: [0]
                            }
                         ],
                        columns: [
                            {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
                            {data: 'customer', name: 'user.last_name', orderable: false, searchable: true},
                            {data: 'product', name: 'application.title', orderable: false, searchable: false},
                            {data: 'amount', name: 'amount', orderable: false, searchable: false},
                            {data: 'payment_date', name: 'payment_date', orderable: false, searchable: false},
                            {data: 'date', name: 'date', orderable: true, searchable: false},
                            {data: 'action', name: 'action', orderable: true, searchable: false}
                        ],
                        order: [[4, 'desc']],
                        "initComplete": function(settings, json) { 
                               $('#loading').delay( 300 ).hide(); 
                               $("#content-table").delay( 300 ).show(); 
                        } 
                    });

                });
            }
                
        });
    })();

</script>
@endsection