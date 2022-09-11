@extends('layouts.inner')

@section('navigation')
@include('inner.user-nav', ['customer' => $customer ])
@endsection


@section('content')
<style>
  .btn-link {
    color: #1e3665;
    text-decoration: none;
  }

  .badge {
    padding: 1.35em 1.65em;
  }
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
  <div class="container-xl">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="app-page-title mb-0">My Bills</h1>
      </div>
    </div>
    <!--//row-->
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
              <table class="table app-table-hover mb-0 text-left reportable-customer">
                <thead>
                  <tr>
                    <th class="cell">#Bill Id</th>
                    <th class="cell">Narration</th>
                    <th class="cell">Created by</th>
                    <th class="cell">Associated order</th>
                    <th class="cell">Amount</th>
                    <th class="cell">Status</th>
                    <th class="cell">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach( $bills as $_bill )
                  @php( $order = \App\Models\Order::find($_bill['order']) )
                  @php( $service = \App\Models\Service::find($order->service) )
                  <tr>
                    <td class="cell">#{{ $_bill['id'] }}</td>
                    <td class="cell">{{ $_bill['narration'] }}</td>
                    <td class="cell">{{ $order->pin == $_bill['created_by'] ? 'System' : $_bill['created_by'] }}</td>
                    <td class="cell">#{{ $order->id }} : {{ $service->name }}</td>
                    <td class="cell">KES {{ number_format($_bill['amount'], 2)  }}</td>
                    <td class="cell">
                      <span class="badge {{ $_bill['payment_status'] == 1 ? 'bg-success' : 'bg-warning'}} ">
                        {{ $_bill['payment_status'] == 1 ? 'paid' : 'pending'}}
                      </span>
                    </td>
                    <td class="cell">
                      @if( $_bill['payment_status'] != 1 )
                      <a href="{{ route('w.u.pay.form', ['id' => $_bill['id']]) }}" class="badge bg-success">Pay Now</a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!--//table-responsive-->
          </div>
          <!--//app-card-body-->
        </div>
      </div>
    </div>
    <!--//tab-content-->
  </div>
  <!--//container-fluid-->


  <div class="container-xl">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="app-page-title mb-0">My orders</h1>
      </div>
    </div>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
              <table class="table app-table-hover mb-0 text-left reportable-customer">
                <thead>
                  <tr>
                    <th class="cell">#Order Id</th>
                    <th class="cell">Service</th>
                    <th class="cell">Cost</th>
                    <th class="cell">Total bills</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach( $orders as $_order )
                  @php( $billsum = \App\Models\User::getOrderBillTotal($_order['id']) )
                  @php( $service = \App\Models\Service::find($_order['service']) )
                  <tr>
                    <td class="cell">#{{ $_order['id'] }}</td>
                    <td class="cell">{{ $service->name }}</td>
                    @if($_order['progress'] == 'complete')
                    <td class="cell">
                      <span class="badge bg-success">
                        Order Completed
                      </span>
                    </td>
                    <td class="cell">
                      <!-- <p class="documents-title">Documents</p> -->
                      @php( $returnDocs = \App\Models\OrderDocument::getReturnDocs($_order['id']))
                      @foreach( $returnDocs as $key => $returnDoc )
                      <a class="btn btn-link" href="{{ route('cust.stream', ['file' => $returnDoc['path'] ]) }}" target="_blank" download="">
                        <i class="fa fa-download"> </i>
                        {{ $returnDoc['title'] }}
                      </a><br>
                      @endforeach
                    </td>
                    @else
                    <td class="cell">KES {{ number_format($service->price, 2)  }}</td>
                    <td class="cell">KES {{ number_format($billsum, 2)  }}</td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!--//table-responsive-->
          </div>
          <!--//app-card-body-->
        </div>
      </div>
    </div>
    <!--//tab-content-->
  </div>
  <!--//container-fluid-->


</div>
<!--//app-content-->

@endsection