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

<style>
    .form-control {
        min-width: 100%;
    }
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Service Groups</h1>
            </div>
        </div>

        <!-- Groups -->
        <nav id="groups-table-tab" class="groups-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="add-group-tab" data-bs-toggle="tab" href="#add-group" role="tab" aria-controls="add-group" aria-selected="true">Add Group</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="all-groups-tab" data-bs-toggle="tab" href="#all-groups" role="tab" aria-controls="all-groups" aria-selected="true">Service groups</a>
        </nav>
        <div class="tab-content" id="groups-table-tab-content">
            <div class="tab-pane fade show active" id="add-group" role="tabpanel" aria-labelledby="add-group-tab">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.add.group') }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Name</label>
                                <input required type="text" name="name" class="form-control" id="setting-input-1" value="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="setting-input-3" class="form-label">Service Artwork</label>
                                <input required type="file" class="form-control" id="setting-input-2" name="artwork">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Order</label>
                                <input required type="number" name="order" class="form-control">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Disclaimer</label>
                                <input required type="text" name="disclaimer" class="form-control">
                            </div>

                            <div class="col-md-12" style="margin-top: 35px !important;">
                                <label class="form-label">Description
                                    <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                                    </span>
                                </label>
                                <textarea class="summernote" name="description"></textarea>
                            </div>

                            <div class="col-md-6" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Add Group</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="all-groups" role="tabpanel" aria-labelledby="all-groups-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left reportable">
                                <thead>
                                    <tr>
                                        <th class="cell">#Order</th>
                                        <th class="cell">Name</th>
                                        <th class="cell">Status</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $groups as $_group )
                                    <tr>
                                        <td class="cell">#{{ $_group['order'] }}</td>
                                        <td class="cell">
                                            <span class="truncate">{{ $_group['name'] }}</span>
                                        </td>
                                        <td class="cell">
                                            <span class="badge {{ $_group['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_group['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                        </td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.view.group', ['id' => $_group['id'] ]) }}">View</a>
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
    </div>
    <!--//container-fluid-->



    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <br><br>
                <h1 class="app-page-title mb-0">Services</h1>
            </div>
        </div>
        <!--//row-->

        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link active" id="admin-services-tab" data-bs-toggle="tab" href="#add-service" role="tab" aria-controls="add-service" aria-selected="true">Add Service</a>
            <a class="flex-sm-fill text-sm-center nav-link" id="list-services-tab" data-bs-toggle="tab" href="#list-services" role="tab" aria-controls="list-services" aria-selected="false">All Services</a>
        </nav>
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="add-service" role="tabpanel" aria-labelledby="admin-services-tab">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form class="settings-form row" method="post" enctype="multipart/form-data" action="{{ route('e.tax.add.service') }}">
                            @csrf
                            {{ \App\Models\User::showFormNotice($errors) }}
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Name <span class="ms-2" data-container="body" data-bs-toggle="popover" data-trigger="hover" data-placement="top" data-content="">
                                    </span>
                                </label>
                                <input required type="text" name="name" class="form-control" id="setting-input-1" value="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">
                                    Deposit(if price is not known)
                                </label>
                                <input required type="number" class="form-control" id="setting-input-2" name="deposit">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Exact Price(Leave deposit blank)</label>
                                <input required type="number" class="form-control" id="setting-input-2" name="price">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Order</label>
                                <input required type="number" class="form-control" id="setting-input-2" placeholder="1" name="order">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Delivery Time</label>
                                <input required type="text" class="form-control" id="setting-input-2" placeholder="24 Hours" name="delivery_time">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-3" class="form-label">Service Group</label>
                                <select class="form-control w-auto" name="type" required>
                                    <option value="">Select group</option>
                                    @foreach( $groups as $_grp )
                                    <option value="{{ $_grp['id'] }}">{{ $_grp['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="setting-input-3" class="form-label">Service Artwork</label>
                                <input required type="file" class="form-control" id="setting-input-2" name="artwork">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="setting-input-3" class="form-label">Description</label>
                                <textarea class="summernote" name="description"></textarea>
                            </div>
                            <div class="col-md-2" style="margin-top: 35px !important;">
                                <button type="submit" class="btn app-btn-primary">Add service</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--//tab-pane-->
            <div class="tab-pane fade" id="list-services" role="tabpanel" aria-labelledby="list-services-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left reportable">
                                <thead>
                                    <tr>
                                        <th class="cell">#Order</th>
                                        <th class="cell">Name</th>
                                        <th class="cell">Group</th>
                                        <th class="cell">Price</th>
                                        <th class="cell">Status</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $all as $_all )
                                    <tr>
                                        <td class="cell">#{{ $_all['order'] }}</td>
                                        <td class="cell">
                                            <span class="truncate">{{ $_all['name'] }}</span>
                                        </td>
                                        <td class="cell">{{ $_all['type_name'] }}</td>
                                        <td class="cell"> KES {{ number_format($_all['price'], 1) }} </td>
                                        <td class="cell">
                                            <span class="badge {{ $_all['enabled'] == 1 ? 'bg-success' : 'bg-danger' }}">{{ $_all['enabled'] == 1 ? 'active' : 'inactive' }}</span>
                                        </td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="{{ route('e.tax.view.service', ['id' => $_all['id'] ]) }}">View</a>

                                            <a class="btn-sm app-btn-secondary red" href="{{ route('e.tax.drop.service', ['id' => $_all['id'] ]) }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
                <!--//app-card-->
            </div>
            <!--//tab-pane-->
        </div>
        <!--//tab-content-->
    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
@endif
@endsection