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
                                on {{ date('d', strtotime($orderDate)) }} {{ date('M', strtotime($orderDate)) }}
                            </li>
                            <li class="list-inline-item">@ {{ date('h:i a', strtotime($orderDate)) }} </li>
                            <li class="list-inline-item">|</li>
                            <li class="list-inline-item">{{ $orderCustomer->fname }} {{ $orderCustomer->lname }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-auto text-center">
                        <form class="row" method="post" action="{{ route('f.send_review') }}">
                            @csrf
                            <div class="col-md-4 mr-2">
                                Update status
                            </div>
                            <div class="col-md-3">
                                <input name="order" value="{{ $thisOrder->id }}" type="hidden" />
                                <select name="new_status" required class="form-select form-select-sm w-auto">
                                    @foreach( $pipelines as $_pip )
                                    @if( $thisOrder->progress == $_pip )
                                    <option selected value="{{ $_pip }}">{{ $_pip }}</option>
                                    @else
                                    <option value="{{ $_pip }}">{{ $_pip }}</option>
                                    @endif
                                    @endforeach
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
                <a class="flex-sm-fill text-sm-center nav-link" id="return-docs-tab" data-bs-toggle="tab" href="#return-docs" role="tab" aria-controls="return-docs" aria-selected="false">Return Documents</a>
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
                <div class="tab-pane fade show" id="return-docs" role="tabpanel" aria-labelledby="return-docs-tab">
                    <p class="text-grey">Once you have finished the task, upload return documents here for the customer to download</p>
                    <hr>
                    <!-- add bill -->
                    <div class="row g-3 mb-4 align-items-center justify-content-between">
                        <div class="col-md-12">
                            <div class="app-card app-card-settings shadow-sm p-4">
                                <div class="app-card-body">
                                    <form enctype="multipart/form-data" class="settings-form row" method="post" action="{{ route('f.add_return_doc') }}">
                                        @csrf
                                        <div class="mb-3 col-md-4">
                                            <input required type="hidden" name="order" value="{{ $thisOrder->id }}">

                                            <input required type="file" name="path" class="form-control" value="{{ old('path') }}">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <input required type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="name of the document">
                                        </div>
                                        <div class="col-md-4" style="margin-top: 5px !important;">
                                            <button type="submit" class="btn app-btn-primary">Add a document</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">{{" "}}</th>
                                    <th class="cell">Title</th>
                                    <th class="cell">Download</th>
                                    <th class="cell">Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $returnDocs as $key => $returnDoc )
                                @php( $date = $returnDoc['created_at'] )
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary red" href="{{ route('f.drop_return_doc', ['id' => $returnDoc['id'] ]) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
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