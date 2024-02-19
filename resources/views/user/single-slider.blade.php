@extends('layouts.inner')

@section('navigation')
  @if( \Auth::user()->root == 1)
    @include('inner.root_nav', ['active' => [0,0,0,0,0,0,'active',0]])
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
        <p class="mb-0"><a class="easy-link" href="{{ route('e.tax.sliders') }}">Back to Sliders</a> </p>
      </div>
    </div>
    <!--//row-->

    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-md-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="app-card-body">
                    <form class="settings-form row" enctype="multipart/form-data" method="post" action="{{ route('e.tax.edit.slider') }}">
                        @csrf
                        {{ \App\Models\User::showFormNotice($errors) }}
                        <input type="hidden" name="id" value="{{ $slider->id }}" />
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-1" class="form-label">Prefix <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                            </span>
                            </label>
                            <input required type="text" value="{{ $slider->prefix }}" name="prefix" class="form-control" id="setting-input-1" value="">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-2" class="form-label">Slider Title</label>
                            <input required type="text" value="{{ $slider->title }}" class="form-control" id="setting-input-2" name="title">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Subtitle</label>
                            <input required type="text" value="{{ $slider->description }}" class="form-control" name="description">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">
                                Slider Image
                                <img src="{{ $slider->image }}" height="40" width="40" alt="slider" />
                            </label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Link</label>
                            <input required type="url" value="{{ $slider->url }}" class="form-control" name="url">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Link Text</label>
                            <input required type="text" value="{{ $slider->button_text }}" class="form-control" name="button_text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Order</label>
                            <input required type="number" value="{{ $slider->order }}" class="form-control" name="order">
                        </div>
                        <div class="col-md-3" style="margin-top: 35px !important;">
                            <button type="submit" class="btn app-btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
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