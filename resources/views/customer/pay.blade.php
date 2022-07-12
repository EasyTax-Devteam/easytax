@extends('layouts.inner')

@section('navigation')
@include('inner.user-nav', ['customer' => $customer ])
@endsection


@section('content')
<style>
    .holder {
        padding: 25px !important;
    }
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Pay Bill</h1>
            </div>
        </div>
        <!--//row-->
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="holder">
                            <form class="settings-form row" method="post" action="{{ route('w.u.post.pay') }}">
                                @csrf
                                <div class="mb-2 col-md-12">
                                    {{ \App\Models\User::showFormNotice($errors) }}
                                    <p class="mt-4">Your Mpesa will be debited <b>KES {{ number_format($amount, 0)}}</b></p>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <input type="hidden" name="bill" value="{{ $bill }}">
                                    <input type="hidden" name="amount" value="{{ $amount }}">
                                    <input required type="text" name="MpesaPhone" class="form-control" value="{{ old('MpesaPhone') }}" placeholder="Mpesa Phone Number">
                                </div>
                                <div class="col-md-4" style="margin-top: 5px !important;">
                                    <button type="submit" class="btn app-btn-primary">Pay Now</button>
                                </div>
                            </form>
                            <hr>
                            <form class="settings-form row" method="post" action="{{ route('w.u.check.pay.status') }}">
                                @csrf
                                <div class="mb-2 col-md-12">
                                    <p class="mt-4">Finished Paying? Click below button to check status.</b></p>
                                </div>
                                <div class="col-md-4" style="margin-top: 5px !important;">
                                    <button type="submit" class="btn app-btn-primary">Check Payment Status</button>
                                </div>
                            </form>

                            <hr>

                        </div>
                        <div class="holder">
                            <div class="app-card-footer px-4 py-3">
                                <a class="action-link" href="{{ route('w.u.orders') }}">Back to Bills <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right ms-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

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

@endsection