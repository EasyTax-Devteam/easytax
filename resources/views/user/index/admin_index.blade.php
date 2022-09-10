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

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">My tasks</h1>
            </div>
        </div>


        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="orders-in-progres-tab" data-bs-toggle="tab" href="#orders-in-progres" role="tab" aria-controls="orders-in-progres" aria-selected="false">In Progress</a>

            <a class="flex-sm-fill text-sm-center nav-link" id="orders-awaiting-approval-tab" data-bs-toggle="tab" href="#orders-awaiting-approval" role="tab" aria-controls="orders-awaiting-approval" aria-selected="false">Awaiting Approval</a>

            <a class="flex-sm-fill text-sm-center nav-link" id="orders-completed-tab" data-bs-toggle="tab" href="#orders-completed" role="tab" aria-controls="orders-completed" aria-selected="false">Completed</a>
        </nav>


        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-in-progres" role="tabpanel" aria-labelledby="orders-in-progres-tab">
                <div class="app-card app-card-orders-table mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">

                            <table class="table mb-0 text-left reportable">
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
                                    @foreach( $inProgress as $_inProg )
                                    @php( $service = \App\Models\Service::find($_inProg['service']) )
                                    @php( $customer = \App\Models\Customer::find($_inProg['customer']) )
                                    @php( $date = $_inProg['created_at'] )
                                    @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_inProg['id']) )
                                    @php( $pipeline = \App\Models\User::getOrderPipeline($_inProg['progress']) )
                                    @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_inProg['id']) )
                                    <tr>
                                        <td class="cell">#{{ $_inProg['id'] }}</td>
                                        <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                        <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                        <td class="cell"><span>{{ date('d', strtotime($date)) }} {{ date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                        <td class="cell">{!! $pipeline !!}</td>
                                        <td class="cell">
                                            KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                            <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                        </td>
                                        <td class="cell"><a class="btn-sm app-btn-secondary" target="_blank" href="{{ route('e.tax.order', ['id' => $_inProg['id'] ] ) }}">View</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--//table-responsive-->
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
            <!--//tab-pane-->

            <div class="tab-pane fade" id="orders-awaiting-approval" role="tabpanel" aria-labelledby="orders-awaiting-approval-tab">
                <div class="app-card app-card-orders-table mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 text-left reportable">
                                <thead>
                                    <tr>
                                        <th class="cell">Order</th>
                                        <th class="cell">Product</th>
                                        <th class="cell">Customer</th>
                                        <th class="cell">Date</th>
                                        <th class="cell">Return Docs</th>
                                        <th class="cell">Total</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $inReview as $_inRev )
                                    @php( $service = \App\Models\Service::find($_inRev['service']) )
                                    @php( $customer = \App\Models\Customer::find($_inRev['customer']) )
                                    @php( $date = $_inRev['created_at'] )
                                    @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_inRev['id']) )
                                    @php( $pipeline = \App\Models\User::getOrderPipeline($_inRev['progress']) )
                                    @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_inRev['id']) )
                                    <tr>
                                        <td class="cell">#{{ $_inRev['id'] }}</td>
                                        <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                        <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                        <td class="cell"><span>{{ date('d', strtotime($date)) }} {{ date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                        <td class="cell">{!! $pipeline !!}</td>
                                        <td class="cell">
                                            KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                            <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                        </td>
                                        <td class="cell"><a class="btn-sm app-btn-secondary" target="_blank" href="{{ route('e.tax.order', ['id' => $_inRev['id'] ] ) }}">View</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--//table-responsive-->
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
            <!--//tab-pane-->

            <div class="tab-pane fade" id="orders-completed" role="tabpanel" aria-labelledby="orders-completed-tab">
                <div class="app-card app-card-orders-table mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 text-left reportable">
                                <thead>
                                    <tr>
                                        <th class="cell">Order</th>
                                        <th class="cell">Product</th>
                                        <th class="cell">Customer</th>
                                        <th class="cell">Date</th>
                                        <th class="cell">Return Docs</th>
                                        <th class="cell">Total</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $approved as $_complete )
                                    @php( $service = \App\Models\Service::find($_complete['service']) )
                                    @php( $customer = \App\Models\Customer::find($_complete['customer']) )
                                    @php( $date = $_complete['created_at'] )
                                    @php( $paymentStatus = \App\Models\User::getOrderBillPaid($_complete['id']) )
                                    @php( $pipeline = \App\Models\User::getOrderPipeline($_complete['progress']) )
                                    @php( $getOrderBillTotals = \App\Models\User::getOrderBillTotals($_complete['id']) )
                                    <tr>
                                        <td class="cell">#{{ $_complete['id'] }}</td>
                                        <td class="cell"><span class="truncate">{{ $service->name }}</span></td>
                                        <td class="cell">{{ $customer->fname }} - {{ $customer->pin }}</td>
                                        <td class="cell"><span>{{ date('d', strtotime($date)) }} {{ date('M', strtotime($date)) }}</span><span class="note">{{ date('h:i a', strtotime($date)) }}</span></td>
                                        <td class="cell">{!! $pipeline !!}</td>
                                        <td class="cell">
                                            KES {{ number_format($getOrderBillTotals[0], 2) }} <br>
                                            <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-warning' }} tiny">paid kes {{ number_format($getOrderBillTotals[1], 2) }}</span>
                                        </td>
                                        <td class="cell"><a class="btn-sm app-btn-secondary" target="_blank" href="{{ route('e.tax.order', ['id' => $_complete['id'] ] ) }}">View</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--//table-responsive-->
                    </div>
                    <!--//app-card-body-->
                </div>
                <!--//app-card-->
            </div>
            <!--//tab-pane-->
        </div>
        <!--//tab-content-->
    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
@endsection