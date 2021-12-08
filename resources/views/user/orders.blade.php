@extends('layouts.inner')

@section('navigation')
    @include('inner.nav', ['active' => [0,0,'active', 0,0,0,0,0]])
@endsection


@section('content')

@if( \Auth::user()->admin == 1 )
	<div class="app-content pt-3 p-md-3 p-lg-4">
		<div class="container-xl">
			
		</div>
	</div>
@endif


@if( \Auth::user()->root == 1)

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Orders</h1>
            </div>
            <div class="col-auto">
                    <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            <form class="table-search-form row gx-1 align-items-center">
                                <div class="col-auto">
                                    <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn app-btn-secondary">Search</button>
                                </div>
                            </form>
                            
                        </div><!--//col-->
                        <div class="col-auto">
                            <select class="form-select w-auto" >
                                <option selected value="option-1">All</option>
                                <option value="option-2">This week</option>
                                <option value="option-3">This month</option>
                                <option value="option-4">Last 3 months</option>
                            </select>
                        </div>
                    </div><!--//row-->
                </div><!--//table-utilities-->
            </div><!--//col-auto-->
        </div><!--//row-->
        
        
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
@endsection