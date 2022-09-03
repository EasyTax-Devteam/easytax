@extends('layouts.inner')

@section('navigation')
@if( \Auth::user()->root == 1)
@include('inner.root_nav', ['active' => [0,0,0,0,0,'active', 0,0,0,0,0,0]])
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
                <h1 class="app-page-title mb-0">Portal Settings</h1>
            </div>
        </div>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form class="settings-form" method="post" enctype="multipart/form-data" action="{{ route('e.tax.update.settings') }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-1" class="form-label">Email </label>
                                    <input required type="email" name="email" class="form-control" value="{{ $settings->email }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-1" class="form-label">Support email </label>
                                    <input required type="email" name="support_email" class="form-control" value="{{ $settings->support_email }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Office Phone</label>
                                    <input required type="text" name="phone" class="form-control" value="{{ $settings->phone }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Office Address</label>
                                    <input required type="text" name="address" class="form-control" value="{{ $settings->address }}">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Office hours</label>
                                    <input required type="text" name="working_hours" class="form-control" value="{{ $settings->working_hours }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Facebook page</label>
                                    <input required type="text" name="facebook" class="form-control" value="{{ $settings->facebook }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Twitter account</label>
                                    <input required type="text" name="twitter" class="form-control" value="{{ $settings->twitter }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Linkedin page</label>
                                    <input required type="text" name="linkedin" class="form-control" value="{{ $settings->linkedin }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="setting-input-3" class="form-label">Instagram page</label>
                                    <input required type="text" name="instagram" class="form-control" value="{{ $settings->instagram }}">
                                </div>
                                <!-- btn -->
                                <div class="col-md-6" style="margin-top: 35px !important;">
                                    <button type="submit" class="btn app-btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif
@endsection