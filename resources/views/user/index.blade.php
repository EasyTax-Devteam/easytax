@extends('layouts.inner')

@section('navigation')
  @include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
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
    <h1 class="app-page-title">Overview</h1>
    <!--//app-card-->
    <div class="row g-4 mb-4">
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Total Sales</h4>
            <div class="stats-figure">KES {{ number_format($data['sales'], 2)}}</div>
            <div class="stats-meta text-success"></div>
          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="#"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Customers</h4>
            <div class="stats-figure">{{ $data['customers'] }}</div>
            <div class="stats-meta text-success"></div>
          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="#"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Services</h4>
            <div class="stats-figure">{{ $data['services'] }}</div>
            <div class="stats-meta"> Active</div>
          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="#"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
          <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Orders</h4>
            <div class="stats-figure">{{ $data['orders'] }}</div>
            <div class="stats-meta">New</div>
          </div>
          <!--//app-card-body-->
          <a class="app-card-link-mask" href="#"></a>
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
    </div>
    <!--//row-->
    <div class="row g-4 mb-4">
      <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
          <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
              <div class="col-auto">
                <h4 class="app-card-title">Order & Sales trends</h4>
              </div>
              <!--//col-->
              <div class="col-auto">
                <div class="card-header-action"></div>
                <!--//card-header-actions-->
              </div>
              <!--//col-->
            </div>
            <!--//row-->
          </div>
          <!--//app-card-header-->
          <div class="app-card-body p-3 p-lg-4">
            <div class="mb-3 d-flex"></div>
            <div class="chart-container">
              <canvas id="canvas-linechart"></canvas>
            </div>
          </div>
          <!--//app-card-body-->
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
      <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
          <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
              <div class="col-auto">
                <h4 class="app-card-title">Monthily Orders - Last 6months</h4>
              </div>
              <!--//col-->
              <div class="col-auto">
                <div class="card-header-action"></div>
                <!--//card-header-actions-->
              </div>
              <!--//col-->
            </div>
            <!--//row-->
          </div>
          <!--//app-card-header-->
          <div class="app-card-body p-3 p-lg-4">
            <div class="mb-3 d-flex"></div>
            <div class="chart-container">
              <canvas id="canvas-barchart"></canvas>
            </div>
          </div>
          <!--//app-card-body-->
        </div>
        <!--//app-card-->
      </div>
      <!--//col-->
    </div>
  </div>
  <!--//container-fluid-->
</div>
<!--//app-content-->
@endif
@endsection