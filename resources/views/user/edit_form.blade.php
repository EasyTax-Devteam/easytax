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
                <a class="" href="{{ route('e.tax.view.service', ['id' => $service->id ]) }}">
                    << Back To {{ $service->name }} </a>
                        <h1 class="app-page-title mb-0">Edit Service Form</h1>
            </div>
        </div>
        <!--//row-->

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-md-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <!-- Form fields -->
                    <div class="app-card-body">
                        <div class="col-auto">
                            <h1 class="app-page-title mb-0">Form Fields</h1>
                        </div>
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.edit.form', ['id' => $form->id ]) }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-3">
                                <input type="hidden" name="service" value="{{ $service->id }}" />
                                <label for="setting-input-1" class="form-label">field_label </label>
                                <input required type="text" name="field_label" class="form-control" value="{{ $form->field_label }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_is_required </label>
                                <select class="form-select form-control" name="field_is_required" required>
                                    <option value="">Select One</option>
                                    @foreach( $booleans as $rekey => $revalue )
                                    @if($form->field_is_required == $rekey )
                                    <option selected value="{{ $rekey }}">{{ $revalue }}</option>
                                    @else
                                    <option value="{{ $rekey }}">{{ $revalue }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_name </label>
                                <input required type="text" name="field_name" class="form-control" value="{{ $form->field_name }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_placeholder </label>
                                <input required type="text" name="field_placeholder" class="form-control" value="{{ $form->field_placeholder }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">default_value </label>
                                <input type="text" name="field_default_value" class="form-control" value="{{ $form->field_default_value }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_type </label>
                                <input required type="text" name="field_type" class="form-control" value="{{ $form->field_type }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_is_multiple </label>
                                <select class="form-select form-control" name="field_is_multiple" required>
                                    <option value="">Select One</option>
                                    @foreach( $booleans as $bkey => $bvalue )
                                    @if($form->field_is_multiple == $bkey )
                                    <option selected value="{{ $bkey }}">{{ $bvalue }}</option>
                                    @else
                                    <option value="{{ $bkey }}">{{ $bvalue }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_max_uploads </label>
                                <input required type="number" name="field_max_uploads" class="form-control" value="{{ $form->field_max_uploads }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-1" class="form-label">field_order </label>
                                <input required type="number" name="order" class="form-control" value="{{ $form->order }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-1" class="form-label">validation_rule </label>
                                <input required type="text" name="validation_rule" class="form-control" value="{{ $form->validation_rule }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="setting-input-3" class="form-label">field_options_json</label>
                                <textarea rows="4" class="form-control" name="field_options_json">{{ $form->field_options_json }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-3" class="form-label">field_form_code</label>
                                <textarea rows="4" class="form-control" name="field_form_code">{{ $form->field_form_code }}</textarea>
                            </div>

                            <div class="col-md-2" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- end forms  -->
                </div>

            </div>
        </div>
    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
@endif
@endsection