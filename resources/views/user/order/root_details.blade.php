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
                                on {{ date('d', strtotime($orderDate)) }} {{ date('M', strtotime($orderDate)) }}
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
                                <select name="admin" required class="form-select form-select-sm w-auto" @if( in_array($thisOrder->progress, ['in_review','complete']) ) disabled @endif >
                                    <option value="">Assigned to...</option>
                                    @foreach( $admins as $_admin )
                                    @if( is_object($user) && $user->id == $_admin['id'] )
                                    <option selected value="{{ $_admin['id'] }}">{{ $_admin['name'] }}</option>
                                    @else
                                    <option value="{{ $_admin['id'] }}">{{ $_admin['name'] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                @if( $thisOrder->progress == 'in_review' )
                                <button type="button" class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#approve-mdl">
                                    Approve Task
                                </button>
                                @elseif($thisOrder->progress == 'complete')
                                <!-- nothing -->
                                @else
                                <button type="submit" class="btn app-btn-primary">{{ $assigned ? 're-assign' : 'assign'}} </button>
                                @endif
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
                @if( in_array($thisOrder->progress, ['in_review','complete']) )
                <a class="flex-sm-fill text-sm-center nav-link" id="return-docs-tab" data-bs-toggle="tab" href="#return-docs" role="tab" aria-controls="return-docs" aria-selected="false">Return Documents</a>
                @endif
            </nav>

            <div class="tab-content" id="orders-table-tab-content">
                <div class="tab-pane fade show active" id="order-info" role="tabpanel" aria-labelledby="order-info-tab">
                    <!-- Information -->
                    @php( $orderInfo = json_decode($thisOrder->order_requested, true) )
                    <div class="app-card-body p-4">

                        <h4 class="notification-title mb-1">Customer information</h4>
                        <hr>
                        <div class="notification-content row">
                            <div class="col-md-4">
                                <div class="item-label custom-label-adm"><strong>Name </strong></div>
                                <div class="item-data">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</div>
                                <br>
                            </div>
                            <div class="col-md-4">
                                <div class="item-label custom-label-adm"><strong>Email Address </strong></div>
                                <div class="item-data">{{ $orderCustomer->email  }}</div>
                                <br>
                            </div>
                            <div class="col-md-4">
                                <div class="item-label custom-label-adm"><strong>Phone number </strong></div>
                                <div class="item-data">{{ $orderCustomer->phone }}</div>
                                <br>
                            </div>
                        </div>
                        <br>
                        <h4 class="notification-title mb-1">Requested Order Details</h4>
                        <hr>
                        <div class="notification-content">
                            @foreach( $orderInfo as $ikey => $ivalue )
                            @php( $formatedLabel = \App\Models\User::nameTolabel($ikey) )
                            <div class="col-auto">
                                <div class="item-label custom-label-adm">
                                    <strong>{{ $formatedLabel }} </strong>
                                </div>
                                @if( is_array($ivalue) )
                                @foreach( $ivalue as $fileEntry )
                                <div class="item-data">
                                    <a class="btn btn-custom" href="{{ route('f.stream', ['file' => $fileEntry['path'] ]) }}" target="_blank">{{ $fileEntry['name'] }}</a>
                                </div>
                                @endforeach
                                @else
                                <div class="item-data">{{ $ivalue }}</div>
                                @endif
                                <br>
                            </div>
                            @endforeach
                        </div>
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
                                        <span>{{ date('d', strtotime($date)) }} {{ date('M', strtotime($date)) }}</span>
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
                @if( in_array($thisOrder->progress, ['in_review','complete']) )
                <div class="tab-pane fade show" id="return-docs" role="tabpanel" aria-labelledby="return-docs-tab">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">Title</th>
                                    <th class="cell">Download</th>
                                    <th class="cell">Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $returnDocs as $key => $returnDoc )
                                @php( $date = $returnDoc['created_at'] )
                                <td class="cell">{{ $returnDoc['title'] }}</td>
                                <td class="cell">
                                    <a class="btn btn-custom" href="{{ route('f.stream', ['file' => $returnDoc['path'] ]) }}" target="_blank" download="">
                                        <i class="fa fa-file-pdf"> </i>
                                        Download
                                    </a>
                                </td>
                                <td class="cell">
                                    <span>{{ date('d', strtotime($date)) }} {{ date('M', strtotime($date)) }}</span>
                                    <span class="note">{{ date('h:i a', strtotime($date)) }}</span>
                                </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="app-card-footer px-4 py-3">
                <a class="action-link" href="{{ route('e.tax.orders') }}">Back to orders <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!--//container-fluid-->
</div>


<div class="modal fade" id="approve-mdl" tabindex="-1" aria-labelledby="approve-mdlLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approve-mdlLabel">Approve this Task?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    Kindly note that this action cannot be <b>reversed</b>.
                    <br>
                    Once approved, the customer will be notified and they will have access to download any return documents attached on this task.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Not now</button>
                <form method="post" action="{{ route('f.mark_approved') }}">
                    @csrf
                    <input type="hidden" name="order" value="{{ $thisOrder->id }}" />
                    <button type="submit" class="btn btn-custom">Approve Task</button>
                </form>
            </div>
        </div>
    </div>
</div>