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
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.edit.service', ['id' => $service->id ]) }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-4">
                                <label for="setting-input-1" class="form-label">Name <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                                    </span>
                                </label>
                                <input required type="text" name="name" class="form-control" id="setting-input-1" value="{{  $service->name }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="setting-input-2" class="form-label">Price in KES</label>
                                <input required type="number" class="form-control" id="setting-input-2" name="price" value="{{  $service->price }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="setting-input-3" class="form-label">Service Group</label>
                                <select class="form-select w-auto" name="type" required>
                                    <option value="">Select group</option>
                                    @foreach( $groups as $_grp )
                                    @if( $service->type == $_grp['id'] )
                                    <option selected value="{{ $_grp['id'] }}">{{ $_grp['name'] }}</option>
                                    @else
                                    <option value="{{ $_grp['id'] }}">{{ $_grp['name'] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="setting-input-3" class="form-label">Service Artwork
                                    <img src="{{ $service->artwork }}" style="width:100px;height:auto" />
                                </label>
                                <input required type="file" class="form-control" id="setting-input-2" name="artwork">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="setting-input-3" class="form-label">Description</label>
                                <textarea class="summernote" name="description">{{ $service->description }}</textarea>
                            </div>
                            <div class="col-md-2" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <hr>
                    <!-- Form fields -->
                    <div class="app-card-body">
                        <div class="col-auto">
                            <h1 class="app-page-title mb-0">Form Fields</h1>
                        </div>
                        <br>
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.add.form') }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-3">
                                <input type="hidden" name="service" value="{{ $service->id }}" />
                                <label for="setting-input-1" class="form-label">field_label </label>
                                <input required type="text" name="field_label" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_is_required </label>
                                <select class="form-select form-control" name="field_is_required" required>
                                    <option value="">Select One</option>
                                    @foreach( $booleans as $rekey => $revalue )
                                    <option value="{{ $rekey }}">{{ $revalue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_name </label>
                                <input required type="text" name="field_name" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_placeholder </label>
                                <input required type="text" name="field_placeholder" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">default_value </label>
                                <input type="text" name="field_default_value" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_type </label>
                                <input required type="text" name="field_type" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_is_multiple </label>
                                <select class="form-select form-control" name="field_is_multiple" required>
                                    <option value="">Select One</option>
                                    @foreach( $booleans as $bkey => $bvalue )
                                    <option value="{{ $bkey }}">{{ $bvalue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-1" class="form-label">field_max_uploads </label>
                                <input required type="number" name="field_max_uploads" class="form-control" value="0">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-1" class="form-label">field_order </label>
                                <input required type="number" name="order" class="form-control" value="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-1" class="form-label">validation_rule </label>
                                <input required type="text" name="validation_rule" class="form-control" value="required|string">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="setting-input-3" class="form-label">field_options_json</label>
                                <textarea rows="4" class="form-control" name="field_options_json"></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="setting-input-3" class="form-label">field_form_code</label>
                                <textarea rows="4" class="form-control" name="field_form_code"></textarea>
                            </div>

                            <div class="col-md-2" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Add form field</button>
                            </div>
                        </form>
                        <hr>
                        <br>
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">{{" "}}</th>
                                        <th class="cell">service</th>
                                        <th class="cell">field_label</th>
                                        <th class="cell">field_is_required</th>
                                        <th class="cell">field_name</th>
                                        <th class="cell">field_id</th>
                                        <th class="cell">field_placeholder</th>
                                        <th class="cell">field_default_value</th>
                                        <th class="cell">field_type</th>
                                        <th class="cell">field_is_multiple</th>
                                        <th class="cell">field_max_uploads</th>
                                        <th class="cell">field_options_json</th>
                                        <th class="cell">order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $forms as $key => $_form )
                                    <tr>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.view.form', ['id' => $_form['id'] ]) }}">Edit</a>
                                        </td>
                                        <td class="cell">#{{ $_form['service'] }}</td>
                                        <td class="cell">{{ $_form['field_label'] }}</td>
                                        <td class="cell">
                                            <span class="badge {{ $_form['field_is_required'] == 0 ? 'bg-danger' : 'bg-success' }}">{{ $_form['field_is_required'] == 0 ? 'No' : 'Yes' }}</span>
                                        </td>
                                        <td class="cell">{{ $_form['field_name'] }}</td>
                                        <td class="cell">{{ $_form['field_id'] }}</td>
                                        <td class="cell">{{ $_form['field_placeholder'] }}</td>
                                        <td class="cell">{{ $_form['field_default_value'] }}</td>
                                        <td class="cell">{{ $_form['field_type'] }}</td>
                                        <td class="cell">
                                            <span class="badge {{ $_form['field_is_multiple'] == 0 ? 'bg-danger' : 'bg-success' }}">{{ $_form['field_is_multiple'] == 0 ? 'No' : 'Yes' }}</span>
                                        </td>
                                        <td class="cell">{{ $_form['field_max_uploads'] }}</td>
                                        <td class="cell">{{ $_form['field_options_json'] }}</td>
                                        <td class="cell">{{ $_form['order'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--//table-responsive-->
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