@extends('layouts.inner')

@section('navigation')
  @if( \Auth::user()->root == 1)
    @include('inner.root_nav', ['active' => [0,0,'active', 0,0,0,0,0,0]])
  @else
    @include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
  @endif
@endsection


@section('content')



@if( \Auth::user()->admin == 1 )
@php( $orderService = \App\Models\Service::find($thisOrder->service) )
@php( $orderDate = $thisOrder->created_at )
@php( $orderCustomer = \App\Models\Customer::find($thisOrder->customer) )
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
      <div class="position-relative mb-3">
        <div class="row g-3 justify-content-between">
          <div class="col-auto">
            <h1 class="app-page-title mb-0"><a href="{{ route('e.tax.index') }}">Tasks</a> > Task #{{ $thisOrder->id }} </h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities"></div>
          </div>
        </div>
      </div>
      <div class="app-card app-card-notification shadow-sm mb-4">
        <div class="app-card-header px-4 py-3">

        {{ \App\Models\User::showFormNotice($errors) }}

          <div class="row g-3 align-items-center">
            <!--//col-->
            <div class="col-md-5">
              <div class="notification-type mb-2">
                <span class="badge bg-info">Order #{{ $thisOrder->id }}</span>
              </div>
              <h4 class="notification-title mb-1">Service: {{ $orderService->name }}</h4>
              <ul class="notification-meta list-inline mb-0">
                <li class="list-inline-item">
                    on {{ date('d', strtotime($orderDate)) }} {{  date('M', strtotime($orderDate)) }}
                </li>
                <li class="list-inline-item">@ {{ date('h:i a', strtotime($orderDate)) }} </li>
                <li class="list-inline-item">|</li>
                <li class="list-inline-item">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</li>
              </ul>
            </div>
            <div class="col-md-6 col-lg-auto text-center">
                <form class="row" method="post" action="{{ route('f.update_status') }}">
                    @csrf
                    <div class="col-md-4 mr-2">
                        Update status
                    </div>
                    <div class="col-md-3">
                        <input name="order" value="{{ $thisOrder->id }}" type="hidden" />
                        <select name="new_status" required class="form-select form-select-sm w-auto">
                            <option selected value="in_progress">In Progress</option>
                            <option value="complete">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn app-btn-primary">
                            Change
                        </button>
                    </div>
                </form>
            </div>
            <!--//col-->
          </div>
          <!--//row-->
        </div>
        <!--//app-card-header-->

        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="order-info-tab" data-bs-toggle="tab" href="#order-info" role="tab" aria-controls="order-info" aria-selected="true">Order information</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="order-bills-tab" data-bs-toggle="tab" href="#order-bills" role="tab" aria-controls="order-bills" aria-selected="false">Bills & Payments</a>
        </nav>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="order-info" role="tabpanel" aria-labelledby="order-info-tab">
                <!-- Information -->

                <div class="app-card-body p-4">
                    @if( in_array($orderService->type,  ['isEmployee', 'isNill', 'isFreelance'] ))
                        <h4 class="notification-title mb-1">Personal information</h4>
                        <div class="notification-content">
                            <div class="col-auto">
                                <div class="item-label"><strong>Name </strong></div>
                                <div class="item-data">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Email Address </strong></div>
                                <div class="item-data">{{ $orderCustomer->email  }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Phone number </strong></div>
                                <div class="item-data">{{ $orderCustomer->phone }}</div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <h4 class="notification-title mb-1">KRA information</h4>
                        <div class="notification-content">
                            <div class="col-auto">
                                <div class="item-label"><strong>KRA PIN number </strong></div>
                                <div class="item-data">{{ $orderCustomer->pin }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>KRA iTax Password </strong></div>
                                <div class="item-data">{{ $orderCustomer->itax_password }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Had Taxable Income </strong></div>
                                <div class="item-data">{{ $thisOrder->has_taxable_income }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Personally pays Kenyan insurance policies </strong></div>
                                <div class="item-data">{{ $thisOrder->paying_kenyan_insurance_policies }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Kenyan Insurance policies </strong></div>
                                <div class="item-data">{{ $thisOrder->kenyan_insurance_policies_paid }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Paid Kenyan Bank Mortgage for the year of income </strong></div>
                                <div class="item-data">{{ $thisOrder->paid_mortgage_for_tax_year }}</div>
                                <br>
                            </div>
                        </div>
                    @endif
                    <div class="notification-content">
                        @if( $orderService->type == 'isEmployee' )
                            <div class="col-auto">
                                <div class="item-label"><strong>P9 Attachment </strong></div>
                                <div class="item-data">
                                    <br>
                                    <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                                        <div class="app-card-thumb-holder p-3">
                                            <span class="icon-holder">
                                            <svg class="svg-inline--fa fa-file-alt fa-w-12 text-file" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm64 236c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-64c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-72v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm96-114.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"></path>
                                            </svg>
                                            </span>
                                            <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank"></a>
                                        </div>
                                        <div class="app-card-body p-3 has-card-actions">
                                            <h4 class="app-doc-title truncate mb-0"> 
                                                <a href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank">P9-pdf-file-attachement</a>
                                            </h4>
                                            <div class="app-doc-meta"></div>
                                            <div class="app-card-actions">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                            </svg>Download </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endif

                        @if( $orderService->type == 'isFreelance' )
                            <div class="col-auto">
                                <div class="item-label">
                                    <strong>Income and Expenses Schedule </strong>
                                </div>
                                <div class="item-data">
                                    <br>
                                    <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                                        <div class="app-card-thumb-holder p-3">
                                            <span class="icon-holder">
                                            <i class="fas fa-file-excel excel-file"></i>
                                            </span>
                                            <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank"></a>
                                        </div>
                                        <div class="app-card-body p-3 has-card-actions">
                                            <h4 class="app-doc-title truncate mb-0"> 
                                                <a href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank">Income-and-Expenses.xlsx</a>
                                            </h4>
                                            <div class="app-doc-meta"></div>
                                            <div class="app-card-actions">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                            </svg>Download </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endif
                    </div>

                    @if( $orderService->type == 'isCompany' )
                    <h4 class="notification-title mb-1">Company information</h4>
                    <div class="notification-content">
                        <div class="col-auto">
                            <div class="item-label"><strong>Company Name </strong></div>
                            <div class="item-data">{{ $orderCustomer->fname }}</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <div class="item-label"><strong>Company Email Address </strong></div>
                            <div class="item-data">{{ $orderCustomer->email }}</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <div class="item-label"><strong>Phone number </strong></div>
                            <div class="item-data">{{ $orderCustomer->phone }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label"><strong>Company KRA PIN </strong></div>
                            <div class="item-data">{{ $orderCustomer->pin }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label"><strong>iTax Password </strong></div>
                            <div class="item-data">{{ $orderCustomer->itax_password }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label">
                                <strong>Financial Statements </strong>
                                @php( $financial_statements = explode(',', $thisOrder->financial_statements) )
                            </div>
                            <br>
                            <div class="item-data">
                                <!-- begin statements -->
                                <div class="row g-4">
                                    @foreach( $financial_statements as $financial_statement )
                                        @php( $extension = explode('.', $financial_statement))
                                        @php( $exkey = end($extension))
                                        <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                                            <div class="app-card app-card-doc shadow-sm h-100">
                                                <div class="app-card-thumb-holder p-3">
                                                    <span class="icon-holder">
                                                    <i class="fas fa-file-excel excel-file"></i>
                                                    </span>
                                                    <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blanl"></a>
                                                </div>
                                                <div class="app-card-body p-3 has-card-actions">
                                                    <h4 class="app-doc-title truncate mb-0">
                                                        <a href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blanl">
                                                            <font style="vertical-align: inherit;">{{ $financial_statement }}</font>
                                                        </a>
                                                    </h4>
                                                    <div class="app-card-actions">
                                                        <div class="dropdown">
                                                            <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                                </svg>
                                                            </div>
                                                            <ul class="dropdown-menu" style="">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blank">
                                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                        <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                                    </svg>Download </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--  end -->
                            </div>
                            <br>
                        </div>
                    </div>
                    @endif
                    
                </div>
                <!--//app-card-body-->

                <!-- information -->
            </div>
            <div class="tab-pane fade show" id="order-bills" role="tabpanel" aria-labelledby="order-bills-tab">
                <!-- Information -->
                <!-- add bill -->
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-md-12">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <form class="settings-form row" method="post" action="{{ route('f.add_bill') }}">
                                    @csrf
                                    <div class="mb-3 col-md-4">
                                        <input required type="hidden" name="order" value="{{ $thisOrder->id }}">
                                        
                                        <input required type="number" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="bill amount">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <input required type="text" name="narration" class="form-control" value="{{ old('narration') }}" placeholder="bill narration">
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px !important;">
                                        <button type="submit" {{ Auth::user()->admin == 1 ? 'disabled' : ''}} class="btn app-btn-primary">Add a bill</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end add bill -->
                <hr>
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Bill ID</th>
                                <th class="cell">Narration</th>
                                <th class="cell">Amount</th>
                                <th class="cell">Created</th>
                                <th class="cell">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $bills as $_bill )
                                 @php( $date = $_bill['created_at'] )
                                 @php( $paymentStatus = $_bill['payment_status'] )
                                <tr>
                                    <td class="cell">#{{ $_bill['id'] }}</td>
                                    <td class="cell">{{ $_bill['narration'] }}</td>
                                    <td class="cell">KES {{ number_format($_bill['amount'], 2) }}</td>
                                    <td class="cell">
                                        <span>{{ date('d', strtotime($date)) }} {{  date('M', strtotime($date)) }}</span>
                                        <span class="note">{{ date('h:i a', strtotime($date)) }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-danger' }}">{{ $paymentStatus == true ? 'paid' : 'pending'}}</span>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- information -->
            </div>
        </div>
        <div class="app-card-footer px-4 py-3">
          <a class="action-link" href="{{ route('e.tax.index') }}">Back to tasks <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right ms-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    
    <!--//container-fluid-->
  </div>
@endif






@if( \Auth::user()->root == 1 )
@php( $orderService = \App\Models\Service::find($thisOrder->service) )
@php( $orderDate = $thisOrder->created_at )
@php( $orderCustomer = \App\Models\Customer::find($thisOrder->customer) )
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
      <div class="position-relative mb-3">
        <div class="row g-3 justify-content-between">
          <div class="col-auto">
            <h1 class="app-page-title mb-0"><a href="{{ route('e.tax.orders') }}">Orders</a> > Order #{{ $thisOrder->id }} </h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities"></div>
          </div>
        </div>
      </div>
      <div class="app-card app-card-notification shadow-sm mb-4">
        <div class="app-card-header px-4 py-3">

        {{ \App\Models\User::showFormNotice($errors) }}

          <div class="row g-3 align-items-center">
            <!--//col-->
            <div class="col-md-5">
              <div class="notification-type mb-2">
                <span class="badge bg-info">Order #{{ $thisOrder->id }}</span>
              </div>
              <h4 class="notification-title mb-1">Service: {{ $orderService->name }}</h4>
              <ul class="notification-meta list-inline mb-0">
                <li class="list-inline-item">
                    on {{ date('d', strtotime($orderDate)) }} {{  date('M', strtotime($orderDate)) }}
                </li>
                <li class="list-inline-item">@ {{ date('h:i a', strtotime($orderDate)) }} </li>
                <li class="list-inline-item">|</li>
                <li class="list-inline-item">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</li>
              </ul>
            </div>
            <div class="col-md-6 col-lg-auto text-center">
                <form class="row" method="post" action="{{ route('f.assign_order') }}">
                    @csrf
                    <div class="col-md-4 mr-2">
                        {{ $assigned ? 'Assigned' : 'Assign'}} To<br>
                        <span class="badge {{ $assigned ? 'bg-success' : 'bg-danger'}}">{{ $assigned ? 'already assigned' : 'not assigned'}}</span>
                    </div>
                    <div class="col-md-3">
                        <input name="order" value="{{ $thisOrder->id }}" type="hidden" />
                        <select name="admin" required class="form-select form-select-sm w-auto">
                            <option value="">Assigned to...</option>
                            @foreach( $admins as $_admin )
                                @if( is_object($user) && $user->id == $_admin['id'] )
                                    <option selected value="{{ $_admin['id'] }}">{{ $_admin['name'] }}</option>
                                @else
                                    <option  value="{{ $_admin['id'] }}">{{ $_admin['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn app-btn-primary">{{ $assigned ? 're-assign' : 'assign'}} </button>
                    </div>
                </form>
            </div>
            <!--//col-->
          </div>
          <!--//row-->
        </div>
        <!--//app-card-header-->

        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="order-info-tab" data-bs-toggle="tab" href="#order-info" role="tab" aria-controls="order-info" aria-selected="true">Order information</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="order-bills-tab" data-bs-toggle="tab" href="#order-bills" role="tab" aria-controls="order-bills" aria-selected="false">Bills & Payments</a>
        </nav>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="order-info" role="tabpanel" aria-labelledby="order-info-tab">
                <!-- Information -->

                <div class="app-card-body p-4">
                    @if( in_array($orderService->type,  ['isEmployee', 'isNill', 'isFreelance'] ))
                        <h4 class="notification-title mb-1">Personal information</h4>
                        <div class="notification-content">
                            <div class="col-auto">
                                <div class="item-label"><strong>Name </strong></div>
                                <div class="item-data">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Email Address </strong></div>
                                <div class="item-data">{{ $orderCustomer->email  }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Phone number </strong></div>
                                <div class="item-data">{{ $orderCustomer->phone }}</div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <h4 class="notification-title mb-1">KRA information</h4>
                        <div class="notification-content">
                            <div class="col-auto">
                                <div class="item-label"><strong>KRA PIN number </strong></div>
                                <div class="item-data">{{ $orderCustomer->pin }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>KRA iTax Password </strong></div>
                                <div class="item-data">{{ $orderCustomer->itax_password }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Had Taxable Income </strong></div>
                                <div class="item-data">{{ $thisOrder->has_taxable_income }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Personally pays Kenyan insurance policies </strong></div>
                                <div class="item-data">{{ $thisOrder->paying_kenyan_insurance_policies }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Kenyan Insurance policies </strong></div>
                                <div class="item-data">{{ $thisOrder->kenyan_insurance_policies_paid }}</div>
                                <br>
                            </div>
                            <div class="col-auto">
                                <div class="item-label"><strong>Paid Kenyan Bank Mortgage for the year of income </strong></div>
                                <div class="item-data">{{ $thisOrder->paid_mortgage_for_tax_year }}</div>
                                <br>
                            </div>
                        </div>
                    @endif
                    <div class="notification-content">
                        @if( $orderService->type == 'isEmployee' )
                            <div class="col-auto">
                                <div class="item-label"><strong>P9 Attachment </strong></div>
                                <div class="item-data">
                                    <br>
                                    <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                                        <div class="app-card-thumb-holder p-3">
                                            <span class="icon-holder">
                                            <svg class="svg-inline--fa fa-file-alt fa-w-12 text-file" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm64 236c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-64c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-72v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm96-114.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"></path>
                                            </svg>
                                            </span>
                                            <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank"></a>
                                        </div>
                                        <div class="app-card-body p-3 has-card-actions">
                                            <h4 class="app-doc-title truncate mb-0"> 
                                                <a href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank">P9-pdf-file-attachement</a>
                                            </h4>
                                            <div class="app-doc-meta"></div>
                                            <div class="app-card-actions">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('f.stream', ['file' => $thisOrder->p_nine_form]) }}" target="_blank">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                            </svg>Download </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endif

                        @if( $orderService->type == 'isFreelance' )
                            <div class="col-auto">
                                <div class="item-label">
                                    <strong>Income and Expenses Schedule </strong>
                                </div>
                                <div class="item-data">
                                    <br>
                                    <div class="app-card app-card-doc shadow-sm" style="width: 200px;">
                                        <div class="app-card-thumb-holder p-3">
                                            <span class="icon-holder">
                                            <i class="fas fa-file-excel excel-file"></i>
                                            </span>
                                            <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank"></a>
                                        </div>
                                        <div class="app-card-body p-3 has-card-actions">
                                            <h4 class="app-doc-title truncate mb-0"> 
                                                <a href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank">Income-and-Expenses.xlsx</a>
                                            </h4>
                                            <div class="app-doc-meta"></div>
                                            <div class="app-card-actions">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                    </svg>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('f.stream', ['file' => $thisOrder->income_and_expenses_schedule]) }}" target="_blank">
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                            </svg>Download </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endif
                    </div>

                    @if( $orderService->type == 'isCompany' )
                    <h4 class="notification-title mb-1">Company information</h4>
                    <div class="notification-content">
                        <div class="col-auto">
                            <div class="item-label"><strong>Company Name </strong></div>
                            <div class="item-data">{{ $orderCustomer->fname }}</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <div class="item-label"><strong>Company Email Address </strong></div>
                            <div class="item-data">{{ $orderCustomer->email }}</div>
                            <br>
                        </div>
                        <div class="col-auto">
                            <div class="item-label"><strong>Phone number </strong></div>
                            <div class="item-data">{{ $orderCustomer->phone }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label"><strong>Company KRA PIN </strong></div>
                            <div class="item-data">{{ $orderCustomer->pin }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label"><strong>iTax Password </strong></div>
                            <div class="item-data">{{ $orderCustomer->itax_password }}</div>
                            <br>
                        </div>

                        <div class="col-auto">
                            <div class="item-label">
                                <strong>Financial Statements </strong>
                                @php( $financial_statements = explode(',', $thisOrder->financial_statements) )
                            </div>
                            <br>
                            <div class="item-data">
                                <!-- begin statements -->
                                <div class="row g-4">
                                    @foreach( $financial_statements as $financial_statement )
                                        @php( $extension = explode('.', $financial_statement))
                                        @php( $exkey = end($extension))
                                        <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                                            <div class="app-card app-card-doc shadow-sm h-100">
                                                <div class="app-card-thumb-holder p-3">
                                                    <span class="icon-holder">
                                                    <i class="fas fa-file-excel excel-file"></i>
                                                    </span>
                                                    <a class="app-card-link-mask" href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blanl"></a>
                                                </div>
                                                <div class="app-card-body p-3 has-card-actions">
                                                    <h4 class="app-doc-title truncate mb-0">
                                                        <a href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blanl">
                                                            <font style="vertical-align: inherit;">{{ $financial_statement }}</font>
                                                        </a>
                                                    </h4>
                                                    <div class="app-card-actions">
                                                        <div class="dropdown">
                                                            <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                                                </svg>
                                                            </div>
                                                            <ul class="dropdown-menu" style="">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('f.stream', ['file' => $financial_statement]) }}" target="_blank">
                                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                                        <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                                                    </svg>Download </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--  end -->
                            </div>
                            <br>
                        </div>
                    </div>
                    @endif
                    
                </div>
                <!--//app-card-body-->

                <!-- information -->
            </div>
            <div class="tab-pane fade show" id="order-bills" role="tabpanel" aria-labelledby="order-bills-tab">
                <!-- Information -->
                <!-- add bill -->
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-md-12">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <form class="settings-form row" method="post" action="{{ route('f.add_bill') }}">
                                    @csrf
                                    <div class="mb-3 col-md-4">
                                        <input required type="hidden" name="order" value="{{ $thisOrder->id }}">
                                        
                                        <input required type="number" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="bill amount">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <input required type="text" name="narration" class="form-control" value="{{ old('narration') }}" placeholder="bill narration">
                                    </div>
                                    <div class="col-md-4" style="margin-top: 5px !important;">
                                        <button type="submit" {{ Auth::user()->admin == 1 ? 'disabled' : ''}} class="btn app-btn-primary">Add a bill</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end add bill -->
                <hr>
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Bill ID</th>
                                <th class="cell">Narration</th>
                                <th class="cell">Amount</th>
                                <th class="cell">Created</th>
                                <th class="cell">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $bills as $_bill )
                                 @php( $date = $_bill['created_at'] )
                                 @php( $paymentStatus = $_bill['payment_status'] )
                                <tr>
                                    <td class="cell">#{{ $_bill['id'] }}</td>
                                    <td class="cell">{{ $_bill['narration'] }}</td>
                                    <td class="cell">KES {{ number_format($_bill['amount'], 2) }}</td>
                                    <td class="cell">
                                        <span>{{ date('d', strtotime($date)) }} {{  date('M', strtotime($date)) }}</span>
                                        <span class="note">{{ date('h:i a', strtotime($date)) }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="badge {{ $paymentStatus == true ? 'bg-success' : 'bg-danger' }}">{{ $paymentStatus == true ? 'paid' : 'pending'}}</span>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- information -->
            </div>
        </div>
        <div class="app-card-footer px-4 py-3">
          <a class="action-link" href="{{ route('e.tax.orders') }}">Back to orders <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right ms-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    
    <!--//container-fluid-->
  </div>
@endif
@endsection