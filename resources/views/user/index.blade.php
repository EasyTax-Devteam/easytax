@extends('layouts.inner')

@section('navigation')
  @if( \Auth::user()->root == 1)
    @include('inner.root_nav', ['active' => ['active', 0,0,0,0,0,0]])
  @else
    @include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
  @endif
@endsection


@section('content')

@if( \Auth::user()->admin == 1 )
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">My tasks</h1>
            </div>
        </div>
        
        
        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
            <a class="flex-sm-fill text-sm-center nav-link"  id="orders-paid-tab" data-bs-toggle="tab" href="#orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">In Progress</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="orders-pending-tab" data-bs-toggle="tab" href="#orders-pending" role="tab" aria-controls="orders-pending" aria-selected="false">Completed</a>
        </nav>
        
        
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Order</th>
                                        <th class="cell">Product</th>
                                        <th class="cell">Customer</th>
                                        <th class="cell">Created</th>
                                        <th class="cell">Pipeline</th>
                                        <th class="cell">Bills</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $orders as $_order )
                                        @php( $service = \App\Models\Service::find($_order['service']) )
                                        @php( $customer = \App\Models\Customer::find($_order['customer']) )
                                        @php( $date = $_order['created_at'] )
                                        @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_order['id']) )
                                        @php( $pipeline = \App\Models\User::getOrderPipeline($_order['progress']) )
                                        @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_order['id']) )
                                        <tr>
                                            <td class="cell">#{{ $_order['id'] }}</td>
                                            <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                            <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                            <td class="cell"><span>{{ date('d', strtotime($date)) }} {{  date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                            <td class="cell">{!! $pipeline !!}</td>
                                            <td class="cell">
                                                KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                                <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                            </td>
                                            <td class="cell"><a class="btn-sm app-btn-secondary" href="{{ route('e.tax.order', ['id' => $_order['id'] ] ) }}">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                        
                    </div><!--//app-card-body-->		
                </div><!--//app-card-->
            </div><!--//tab-pane-->
            
            <div class="tab-pane fade" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
                <div class="app-card app-card-orders-table mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            
                            <table class="table mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Order</th>
                                        <th class="cell">Product</th>
                                        <th class="cell">Customer</th>
                                        <th class="cell">Created</th>
                                        <th class="cell">Pipeline</th>
                                        <th class="cell">Bills</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $orders as $_order )
                                        @if( in_array($_order['progress'], ['in_progress', 'in_review']))
                                            @php( $service = \App\Models\Service::find($_order['service']) )
                                            @php( $customer = \App\Models\Customer::find($_order['customer']) )
                                            @php( $date = $_order['created_at'] )
                                            @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_order['id']) )
                                            @php( $pipeline = \App\Models\User::getOrderPipeline($_order['progress']) )
                                            @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_order['id']) )
                                            <tr>
                                                <td class="cell">#{{ $_order['id'] }}</td>
                                                <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                                <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                                <td class="cell"><span>{{ date('d', strtotime($date)) }} {{  date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                                <td class="cell">{!! $pipeline !!}</td>
                                                <td class="cell">
                                                    KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                                    <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                                </td>
                                                <td class="cell"><a class="btn-sm app-btn-secondary" href="{{ route('e.tax.order', ['id' => $_order['id'] ] ) }}">View</a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->		
                </div><!--//app-card-->
            </div><!--//tab-pane-->
            
            <div class="tab-pane fade" id="orders-pending" role="tabpanel" aria-labelledby="orders-pending-tab">
                <div class="app-card app-card-orders-table mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Order</th>
                                        <th class="cell">Product</th>
                                        <th class="cell">Customer</th>
                                        <th class="cell">Date</th>
                                        <th class="cell">Status</th>
                                        <th class="cell">Total</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $orders as $_order )
                                        @if( in_array($_order['progress'], ['complete']))
                                            @php( $service = \App\Models\Service::find($_order['service']) )
                                            @php( $customer = \App\Models\Customer::find($_order['customer']) )
                                            @php( $date = $_order['created_at'] )
                                            @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_order['id']) )
                                            @php( $pipeline = \App\Models\User::getOrderPipeline($_order['progress']) )
                                            @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_order['id']) )
                                            <tr>
                                                <td class="cell">#{{ $_order['id'] }}</td>
                                                <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                                <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                                <td class="cell"><span>{{ date('d', strtotime($date)) }} {{  date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                                <td class="cell">{!! $pipeline !!}</td>
                                                <td class="cell">
                                                    KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                                    <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                                </td>
                                                <td class="cell"><a class="btn-sm app-btn-secondary" href="{{ route('e.tax.order', ['id' => $_order['id'] ] ) }}">View</a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->		
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-fluid-->
</div><!--//app-content-->
@endif


@if( \Auth::user()->root == 1)

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
@endif
@endsection


@section('page_scripts')

@php( $orderLables = implode(',', $ordersGraph['label']))
@php( $orderDatas = implode(',', $ordersGraph['data']))

@php( $revenueLables = implode(',', $revenueGraph['label']))
@php( $revenueDatas = implode(',', $revenueGraph['data']))
<script>
        'use strict';
        window.chartColors = {
            green: '#800000',
            gray: '#f7b3b3',
            text: '#252930',
            border: '#e7e9ed'
        };
        var ordersLables = "{{ $orderLables }}";
        var ordersDatas = "{{ $orderDatas }}";
        var randomDataPoint = function(){ return Math.round(Math.random()*10000)};
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
                },]
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
        window.addEventListener('load', function(){
            
            var lineChart = document.getElementById('canvas-linechart').getContext('2d');
            window.myLine = new Chart(lineChart, lineChartConfig);
            
            var barChart = document.getElementById('canvas-barchart').getContext('2d');
            window.myBar = new Chart(barChart, barChartConfig);
            

        });
    </script>
@endsection