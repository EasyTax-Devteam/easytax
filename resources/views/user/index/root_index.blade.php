@extends('layouts.inner')

@section('navigation')
@if( \Auth::user()->root == 1)
@include('inner.root_nav', ['active' => ['active', 0,0,0,0,0,0]])
@else
@include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
@endif
@endsection


@section('content')

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Overview</h1>
        <!--//app-card-->
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Sales</h4>
                        <div class="stats-figure">KES {{ number_format($data['sales'], 2)}}</div>
                        <div class="stats-meta text-success"></div>
                    </div>
                    <!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Customers</h4>
                        <div class="stats-figure">{{ $data['customers'] }}</div>
                        <div class="stats-meta text-success"></div>
                    </div>
                    <!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Services</h4>
                        <div class="stats-figure">{{ $data['services'] }}</div>
                        <div class="stats-meta"> Active</div>
                    </div>
                    <!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Orders</h4>
                        <div class="stats-figure">{{ $data['orders'] }}</div>
                        <div class="stats-meta">New</div>
                    </div>
                    <!--//app-card-body-->
                    <a class="app-card-link-mask" href="#"></a>
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
        </div>
        <!--//row-->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Order & Sales trends</h4>
                            </div>
                            <!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action"></div>
                                <!--//card-header-actions-->
                            </div>
                            <!--//col-->
                        </div>
                        <!--//row-->
                    </div>
                    <!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="mb-3 d-flex"></div>
                        <div class="chart-container">
                            <canvas id="canvas-linechart"></canvas>
                        </div>
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Monthily Orders - Last 6months</h4>
                            </div>
                            <!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action"></div>
                                <!--//card-header-actions-->
                            </div>
                            <!--//col-->
                        </div>
                        <!--//row-->
                    </div>
                    <!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="mb-3 d-flex"></div>
                        <div class="chart-container">
                            <canvas id="canvas-barchart"></canvas>
                        </div>
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
        </div>
    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->

@endsection


@section('page_scripts')

@php( $orderLables = implode(',', $ordersGraph['label']))
@php( $orderDatas = implode(',', $ordersGraph['data']))

@php( $revenueLables = implode(',', $revenueGraph['label']))
@php( $revenueDatas = implode(',', $revenueGraph['data']))
<script>
    'use strict';
    window.chartColors = {
        green: '#1e3666',
        gray: '#afc7fa',
        text: '#252930',
        border: '#e7e9ed'
    };
    var ordersLables = "{{ $orderLables }}";
    var ordersDatas = "{{ $orderDatas }}";
    var randomDataPoint = function() {
        return Math.round(Math.random() * 10000)
    };
    var lineChartConfig = {
        type: 'line',

        data: {
            labels: ordersLables.split(','),

            datasets: [{
                label: 'Orders',
                fill: false,
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                data: ordersDatas.split(','),
            }, ]
        },
        options: {
            responsive: true,
            aspectRatio: 1.5,

            legend: {
                display: true,
                position: 'bottom',
                align: 'end',
            },

            title: {
                display: true,
                text: 'Order trends',

            },
            tooltips: {
                mode: 'index',
                intersect: false,
                titleMarginBottom: 10,
                bodySpacing: 10,
                xPadding: 16,
                yPadding: 16,
                borderColor: window.chartColors.border,
                borderWidth: 1,
                backgroundColor: '#fff',
                bodyFontColor: window.chartColors.text,
                titleFontColor: window.chartColors.text,

                callbacks: {
                    label: function(tooltipItem, data) {
                        if (parseInt(tooltipItem.value) >= 1000) {
                            return tooltipItem.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } else {
                            return tooltipItem.value;
                        }
                    }
                },

            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,

                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(value, index, values) {
                            return value.toLocaleString();
                        }
                    },
                }]
            }
        }
    };

    var revenuLabel = "{{ $revenueLables }}";
    var revenuDatas = "{{ $revenueDatas }}";
    var barChartConfig = {
        type: 'bar',

        data: {
            labels: revenuLabel.split(','),
            datasets: [{
                label: 'KES ',
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                borderWidth: 1,
                maxBarThickness: 16,
                data: revenuDatas.split(',')
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1.5,
            legend: {
                position: 'bottom',
                align: 'end',
            },
            title: {
                display: true,
                text: 'Monthily Revenue - Last 6months'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                titleMarginBottom: 10,
                bodySpacing: 10,
                xPadding: 16,
                yPadding: 16,
                borderColor: window.chartColors.border,
                borderWidth: 1,
                backgroundColor: '#fff',
                bodyFontColor: window.chartColors.text,
                titleFontColor: window.chartColors.text,

            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },

                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.borders,
                    },
                }]
            }

        }
    }
    window.addEventListener('load', function() {

        var lineChart = document.getElementById('canvas-linechart').getContext('2d');
        window.myLine = new Chart(lineChart, lineChartConfig);

        var barChart = document.getElementById('canvas-barchart').getContext('2d');
        window.myBar = new Chart(barChart, barChartConfig);


    });
</script>
@endsection