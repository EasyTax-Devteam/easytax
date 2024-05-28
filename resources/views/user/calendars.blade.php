@extends('layouts.inner')

@section('navigation')
  @if( \Auth::user()->root == 1)
    @include('inner.root_nav', ['active' => [0,0,0,0,0,0,0,'active',0]])
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
        <h1 class="app-page-title mb-0">{{ date('Y') ."/".intval(substr(date('Y'), -2)) + 1 }} Tax Calendar</h1>
      </div>
    </div>
    <!--//row-->
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Current Clendar Months</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                        <th class="cell">Image</th>
                        <th class="cell">Year</th>
                        <th class="cell">Month</th>
                        <th class="cell">Title</th>
                        <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $all as $_all )
                            <tr>
                                <td class="cell">
                                  <img src="{{ $_all['art_work'] }}" height="60" width="60" alt="slider" />
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $_all['year'] }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $_all['month'] }}</span>
                                </td>
                                <td class="cell">
                                  <a class="easy-link" href="{{ route('e.tax.calendars.show', ['id' => $_all['id']]) }}">
                                  {{ $_all['title'] }}
                                  </a>
                                </td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-primary" href="{{ route('e.tax.calendars.show', ['id' => $_all['id']]) }}">Manage</a>
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.calendars.img.show', ['id' => $_all['id']]) }}">Edit Info</a>
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
</div>
<!--//app-content-->
@endif
@endsection