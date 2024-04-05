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
<style>
  table.calendar{width:100%; border:1px solid #efefef;}
  td.day{width: 14%; height: 140px; border: 1px solid #efefef; vertical-align: top;text-align: right; padding: 5px;}
  td.day span.day-date{font-size: 14pt; font-weight: 700;}
  td.day span.holiday{font-size: 12pt; color: #f56934;}
  th.header{background-color: #6fabe8; color: #fff; font-size: 14pt; padding: 5px; text-align: center;}
  .not-month{background-color: #ededed;}
  td.today {background-color:#efefef;}
  td.day span.today-date{font-size: 16pt;}
 </style>
<div class="app-content pt-3 p-md-3 p-lg-4">
  <div class="container-xl">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="app-page-title mb-0">{{ \App\Models\TaxCalendar::monthName($calendar->month) . " " . $calendar->year }}</h1>
      </div>
    </div>
    <!--//row-->
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-lg-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Current Month Events</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <!-- <pre>{{ print_r($days) }}</pre> -->
            <div class="table-responsive">
               <?=$html?>
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