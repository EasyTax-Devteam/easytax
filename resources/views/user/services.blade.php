@extends('layouts.inner')

@section('navigation')
    @include('inner.nav', ['active' => [0,0,0,'active']])
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
        <h1 class="app-page-title mb-0">Services</h1>
      </div>
    </div>
    <!--//row-->

    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-md-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="app-card-body">
                    <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.add.service') }}">
                        @csrf
                        {{ \App\Models\User::showFormNotice($errors) }}
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-1" class="form-label">Name <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                            </span>
                            </label>
                            <input required type="text" name="name" class="form-control" id="setting-input-1" value="">
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="setting-input-2" class="form-label">Price in KES</label>
                            <input required type="number" class="form-control" id="setting-input-2" name="price">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Service Group</label>
                            <select class="form-select w-auto" name="type" required>
                                <option value="">Select group</option>
                                <option value="isNill">Nill Returns</option>
                                <option value="isEmployee">Employee Returns</option>
                                <option value="isFreelance">Freelance Returns</option>
                                <option value="isCompany">Company Returns</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="setting-input-3" class="form-label">Service Artwork</label>
                            <input required type="file" class="form-control" id="setting-input-2" name="artwork">
                            
                        </div>
                        <div class="col-md-2" style="margin-top: 35px !important;">
                            <button type="submit" class="btn app-btn-primary">Add service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="orders-paid-tab" data-bs-toggle="tab" href="#orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">Active</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="orders-pending-tab" data-bs-toggle="tab" href="#orders-pending" role="tab" aria-controls="orders-pending" aria-selected="false">Inactive</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                        <th class="cell">ID</th>
                        <th class="cell">Name</th>
                        <th class="cell">Group</th>
                        <th class="cell">Price</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $all as $_all )
                            <tr>
                                <td class="cell">#{{ $_all['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_all['name'] }}</span>
                                </td>
                                <td class="cell">{{ $_all['type'] }}</td>
                                <td class="cell"> KES {{ number_format($_all['price'], 1) }} </td>
                                <td class="cell">
                                    <span class="badge {{ $_all['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_all['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="#">View</a>
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
      <!--//tab-pane-->
      <div class="tab-pane fade" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
        <div class="app-card app-card-orders-table mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                        <th class="cell">ID</th>
                        <th class="cell">Name</th>
                        <th class="cell">Group</th>
                        <th class="cell">Price</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $active as $_active )
                            <tr>
                                <td class="cell">#{{ $_active['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_active['name'] }}</span>
                                </td>
                                <td class="cell">{{ $_active['type'] }}</td>
                                <td class="cell"> KES {{ number_format($_active['price'], 1) }} </td>
                                <td class="cell">
                                    <span class="badge {{ $_active['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_active['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.disable.svc', ['id' => $_active['id']]) }}">disable</a>
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
        <!--//app-card-->
      </div>
      <!--//tab-pane-->
      <div class="tab-pane fade" id="orders-pending" role="tabpanel" aria-labelledby="orders-pending-tab">
        <div class="app-card app-card-orders-table mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                        <th class="cell">ID</th>
                        <th class="cell">Name</th>
                        <th class="cell">Group</th>
                        <th class="cell">Price</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $inactive as $_inactive )
                            <tr>
                                <td class="cell">#{{ $_inactive['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_inactive['name'] }}</span>
                                </td>
                                <td class="cell">{{ $_inactive['type'] }}</td>
                                <td class="cell"> KES {{ number_format($_inactive['price'], 1) }} </td>
                                <td class="cell">
                                    <span class="badge {{ $_inactive['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_inactive['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.enable.svc', ['id' => $_inactive['id']]) }}">enable</a>
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
        <!--//app-card-->
      </div>
      <!--//tab-pane-->
    </div>
    <!--//tab-content-->
  </div>
  <!--//container-fluid-->
</div>
<!--//app-content-->
@endif
@endsection