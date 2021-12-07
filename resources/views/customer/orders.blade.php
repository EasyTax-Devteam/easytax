@extends('layouts.inner')

@section('navigation')
    @include('inner.user-nav')
@endsection


@section('content')

<div class="app-content pt-3 p-md-3 p-lg-4">
  <div class="container-xl">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="app-page-title mb-0">My Bills</h1>
      </div>
    </div>
    <!--//row-->
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">#Bill ID</th>
                            <th class="cell">Associated Order</th>
                            <th class="cell">Amount</th>
                            <th class="cell">Status</th>
                            <th class="cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="cell">#1234</td>
                            <td class="cell">#1234 : Abc service</td>
                            <td class="cell">KES 100</td>
                            <td class="cell"> <span class="badge bg-success">awaiting payment</span></td>
                            <td class="cell"> <span class="badge bg-success">Pay Now</span></td>
                        </tr>
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
    <!--//row-->
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">#Order ID</th>
                            <th class="cell">Service</th>
                            <th class="cell">KRA Pin</th>
                            <th class="cell">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="cell">#1234</td>
                            <td class="cell">Abc service</td>
                            <td class="cell">A007234567G</td>
                            <td class="cell"> <span class="badge bg-success">paid</span></td>
                        </tr>
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
