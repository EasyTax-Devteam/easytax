@extends('layouts.inner')

@section('navigation')
@if( \Auth::user()->root == 1)
@include('inner.root_nav', ['active' => [0,0,'active', 0,0,0,0,0,0]])
@else
@include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
@endif
@endsection


@section('content')

<style>
    .tab-pane {
        padding: 20px;
    }

    .btn {
        border-radius: 20px !important;
        min-width: 140px !important;
    }
</style>

@if( \Auth::user()->admin == 1 )
@include('user.order.admin_details')
@endif






@if( \Auth::user()->root == 1 )
@include('user.order.root_details')
@endif

@endsection

<!-- dhhd foof -->
@section('page_scripts')
<script>
    showManPaymentForm = function(billId) {
        var buttonId = 'pay-btn-no-' + billId;
        var rowId = 'pay-td-no-' + billId;
        $('#' + buttonId).hide(1000);
        $('#' + rowId).show(1000);
    }
    closePayForm = function(billId) {
        var buttonId = 'pay-btn-no-' + billId;
        var rowId = 'pay-td-no-' + billId;
        var loader = 'bill-loader-no-' + billId;
        $('.inactive').prop('disabled', false);
        $('#' + loader).hide();
        $('#' + buttonId).show(10);
        $('#' + rowId).hide(10);
    }
    submitManPayment = function(billId) {
        var formName = 'pay-form-no-' + billId;
        var loader = 'bill-loader-no-' + billId;
        $('.inactive').prop('disabled', true);
        $('#' + loader).show();
        var formData = $('form[name=' + formName + ']').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('bill.man.payment') }}",
            data: formData,
            success: function(resp, message, xhr) {
                $('.inactive').prop('disabled', false);
                $('#' + loader).hide();
                if (resp.hasOwnProperty('msg')) {
                    alert('Payment added');
                    setTimeout(() => {
                        location.reload();
                    }, 100)
                    return;
                } else if (resp.hasOwnProperty('err')) {
                    alert(resp.err);
                    return;
                }
            },
            error: function(xhr, status, error) {
                $('.inactive').prop('disabled', false);
                $('#' + loader).hide();
                console.log('error', error);
            }
        })
    }
</script>
@endsection