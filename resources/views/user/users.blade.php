@extends('layouts.inner')

@section('navigation')
  @if( \Auth::user()->root == 1)
    @include('inner.root_nav', ['active' => [0,'active', 0,0,0,0,0,0]])
  @else
    @include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
  @endif
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
        <h1 class="app-page-title mb-0">Admin Users</h1>
      </div>
    </div>
    <!--//row-->

    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-md-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="app-card-body">
                    <form class="settings-form row" method="post" action="{{ route('e.tax.add.user') }}">
                        @csrf
                        {{ \App\Models\User::showFormNotice($errors) }}
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-1" class="form-label">Full Name <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                            </span>
                            </label>
                            <input required type="text" name="name" class="form-control" id="setting-input-1" value="">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-2" class="form-label">Email Address</label>
                            <input required type="email" class="form-control" id="setting-input-2" name="email">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Set default password</label>
                            <input required type="password" class="form-control" name="password">
                        </div>
                        <div class="col-md-3" style="margin-top: 35px !important;">
                            <button type="submit" class="btn app-btn-primary">Add user</button>
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
                        <th class="cell">Email</th>
                        <th class="cell">Name</th>
                        <th class="cell">Created</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $all as $_all )
                            <tr>
                                <td class="cell">#{{ $_all['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_all['email'] }}</span>
                                </td>
                                <td class="cell">{{ $_all['name'] }}</td>
                                <td class="cell">
                                    <span>{{ date('d M', strtotime($_all['created_at'])) }}</span>
                                    <span class="note">{{ date('h:i:s a', strtotime($_all['created_at'])) }}</span>
                                </td>
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
                        <th class="cell">Email</th>
                        <th class="cell">Name</th>
                        <th class="cell">Created</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $active as $_active )
                            <tr>
                                <td class="cell">#{{ $_active['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_active['email'] }}</span>
                                </td>
                                <td class="cell">{{ $_active['name'] }}</td>
                                <td class="cell">
                                    <span>{{ date('d M', strtotime($_active['created_at'])) }}</span>
                                    <span class="note">{{ date('h:i:s a', strtotime($_active['created_at'])) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="badge {{ $_active['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_active['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.disable.user', ['id' => $_active['id']]) }}">disable</a>
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
                        <th class="cell">Email</th>
                        <th class="cell">Name</th>
                        <th class="cell">Created</th>
                        <th class="cell">Status</th>
                        <th class="cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $inactive as $_inactive )
                            <tr>
                                <td class="cell">#{{ $_inactive['id'] }}</td>
                                <td class="cell">
                                    <span class="truncate">{{ $_inactive['email'] }}</span>
                                </td>
                                <td class="cell">{{ $_inactive['name'] }}</td>
                                <td class="cell">
                                    <span>{{ date('d M', strtotime($_inactive['created_at'])) }}</span>
                                    <span class="note">{{ date('h:i:s a', strtotime($_inactive['created_at'])) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="badge {{ $_inactive['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_inactive['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.enable.user', ['id' => $_inactive['id']]) }}">enable</a>
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