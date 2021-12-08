@extends('layouts.inner')

@section('navigation')
    @include('inner.nav', ['active' => [0,0,0,0,0,'active']])
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
        <h1 class="app-page-title mb-0">Customers</h1>
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
                        <th class="cell">ID</th>
                        <th class="cell">Name</th>
                        <th class="cell">KRA Pin</th>
                        <th class="cell">iTax Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $all as $_all )
                            <tr>
                                <td class="cell">#{{ $_all['id'] }}</td>
                                <td class="cell">{{ $_all['fname'] }} {{ $_all['lname'] }}</td>
                                <td class="cell"><span class="truncate">{{ $_all['pin'] }}</span></td>
                                <td class="cell">#{{ $_all['itax_password'] }}</td>
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
@endif
@endsection