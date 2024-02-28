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
        <h1 class="app-page-title mb-0">Home Sliders</h1>
      </div>
    </div>
    <!--//row-->

    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-md-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="app-card-body">
                    <form class="settings-form row" enctype="multipart/form-data" method="post" action="{{ route('e.tax.add.slider') }}">
                        @csrf
                        {{ \App\Models\User::showFormNotice($errors) }}
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-1" class="form-label">Prefix <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                            </span>
                            </label>
                            <input required type="text" name="prefix" class="form-control" id="setting-input-1" value="">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-2" class="form-label">Slider Title</label>
                            <input required type="text" class="form-control" id="setting-input-2" name="title">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Subtitle</label>
                            <input required type="text" class="form-control" name="description">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Image</label>
                            <input required type="file" class="form-control" name="image">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Link</label>
                            <input required type="url" class="form-control" name="url">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Link Text</label>
                            <input required type="text" class="form-control" name="button_text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="setting-input-3" class="form-label">Slider Order</label>
                            <input required type="number" class="form-control" name="order">
                        </div>
                        <div class="col-md-3" style="margin-top: 35px !important;">
                            <button type="submit" class="btn app-btn-primary">Add Slider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All Sliders</a>
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
                        <th class="cell">Prefix</th>
                        <th class="cell">Title</th>
                        <th class="cell">Link URL</th>
                        <th class="cell">Subtitle</th>
                        <th class="cell">Order</th>
                        <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $all as $_all )
                            <tr>
                                <td class="cell">
                                  <img src="{{ $_all['image'] }}" height="60" width="60" alt="slider" />
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $_all['prefix'] }}</span>
                                </td>
                                <td class="cell">
                                  <a class="easy-link" href="{{ route('e.tax.slider', ['id' => $_all['id']]) }}">
                                  {{ $_all['title'] }}
                                  </a>
                                </td>
                                <td class="cell">{{ $_all['url'] }}</td>
                                <td class="cell">{{ $_all['description'] }}</td>
                                <td class="cell">{{ $_all['order'] }}</td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.delete.slider', ['id' => $_all['id']]) }}">Delete</a>
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