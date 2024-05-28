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
        <h1 class="app-page-title mb-0">{{ $title }}</h1>
      </div>
    </div>
    <!--//row-->
    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-lg-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Day Tax Events</a>
    </nav>
    <div class="tab-content" id="orders-table-tab-content">
      <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
          <div class="app-card-body">
            <form class="settings-form" method="post" enctype="multipart/form-data" action="{{ route('e.tax.calendars.day.add', ['id' => $day_id ]) }}">
                @csrf
                {{ \App\Models\User::showFormNotice($errors) }}
                <div class="row">
                    <input required type="hidden" name="title" class="form-control" value="{{ $title }}">
                    
                    <div class="mb-3 col-md-12">
                        <label for="setting-input-3" class="form-label">Event Details</label>
                        <textarea required class="summernote-lg form-control" id="content" type="text" placeholder="" name="content">
                            {{ $event->content }}
                        </textarea>
                    </div>

                    <!-- btn -->
                    <div class="col-md-6" style="margin-top: 35px !important;">
                        <button type="submit" class="btn app-btn-primary">Save changes</button>
                    </div>
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