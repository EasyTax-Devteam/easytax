@extends('layouts.inner')

@section('navigation')
@if( \Auth::user()->root == 1)
@include('inner.root_nav', ['active' => [0,0,0,'active', 0,0,0,0,0,0]])
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
                <h1 class="app-page-title mb-0">Edit Service Group</h1>
            </div>
        </div>
        <!--//row-->

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-md-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.edit.group', ['id' => $service->id ]) }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-1" class="form-label">Name <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                                    </span>
                                </label>
                                <input required type="text" name="name" class="form-control" id="setting-input-1" value="{{ $service->name }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-3" class="form-label">Service Artwork</label>
                                <input type="file" class="form-control" id="setting-input-2" name="artwork">

                            </div>
                            <div class="col-md-12" style="margin-top: 35px !important;">
                                <label for="setting-input-1" class="form-label">Description
                                    <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                                    </span>
                                </label>
                                <textarea class="summernote" name="description">{{ $service->description }}</textarea>
                            </div>

                            <div class="col-md-6" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
@endif
@endsection