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
  td.today {background-color:#72d5f0;}
  td.day span.today-date{font-size: 16pt;}
  .has-evt{
    color: #fff;
    background-color: #6fabe8;
    border-color: #6fabe8;
    text-align: center;
    float: right;
    font-weight: 500;
    min-width: 80px;
    margin: 0px 0px 0px 10px;
  }
  .has-del{
    color: #ff0000;
    background-color: #fff;
    border-color: #ff0000;
    text-align: center;
    float: right;
    font-weight: 500;
  }
  .nav-link-a {
    display: inline!important;
  }
 </style>
<div class="app-content pt-3 p-md-3 p-lg-4">
  <div class="container-xl">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="app-page-title mb-0">
          <a class="nav-link nav-link-a" href="{{ route('e.tax.calendars.calendar') }}">
              <span class="nav-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
              </svg>
              </span>
              <span class="nav-link-text">Back </span>
          </a>
          {{ \App\Models\TaxCalendar::monthName($calendar->month) . " " . $calendar->year }}
        </h1>
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
                <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.calendars.img.add', ['id' => $calendar->id ]) }}">
                    @csrf
                    {{ \App\Models\User::showFormNotice($errors) }}
                    <div class="mb-3 col-md-12">
                        <label for="setting-input-3" class="form-label">banner Image
                        <img src="{{ $calendar->art_work }}" style="width:100px;height:auto" />
                        </label>
                        <input type="file" class="form-control" id="setting-input-2" name="art_work">
                    </div>
                    <div class="col-md-2" style="margin-top: 35px !important;">
                        <button type="submit" class="btn app-btn-primary">Upload Image</button>
                    </div>
                </form>
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