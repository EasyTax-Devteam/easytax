<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="softbucket.io">
    <link rel="shortcut icon" href="favicon.ico">

    <script defer src="{{ asset('auth/assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <link id="theme-style" rel="stylesheet" href="{{ asset('auth/assets/css/portal.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .app-branding .logo-icon {
            width: 120px;
            height: auto;
        }

        .tiny {
            font-size: 8px !important;
        }

        .btn-custom {
            color: #fff !important;
            background-color: #1e3665;
            margin-bottom: 13px;
            min-width: 200px;
            border-radius: 20px;
        }

        .custom-label-adm {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .app-card-body {
            padding: 20px;
        }

        .red {
            color: red !important;
        }
        .easy-link{
            color: green;
        }
    </style>
</head>

<body class="app">
    <header class="app-header fixed-top">
        @yield('navigation')
    </header>

    <div class="app-wrapper">

        @yield('content')

        <footer class="app-footer">
            <div class="container text-center py-3">
                <small class="copyright">© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</small>
            </div>
        </footer>
        <!--//app-footer-->

    </div>
    <!--//app-wrapper-->


    <!-- Javascript -->
    <script src="{{ asset('auth/assets/plugins/popper.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('auth/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('auth/assets/plugins/chart.js/chart.min.js') }}"></script>
    <!-- <script src="{{ asset('auth/assets/js/index-charts.js') }}"></script>  -->

    <!-- Page Specific JS -->
    <script src="{{ asset('auth/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    @yield('page_scripts')


    <script>
        prettyPrint = function(field_options_json) {
            var ugly = document.getElementById(field_options_json).value;
            var obj = JSON.parse(ugly);
            var pretty = JSON.stringify(obj, undefined, 4);
            document.getElementById(field_options_json).value = pretty;
        }

        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Type your text here',
                tabsize: 2,
                height: 150
            });

            /** dataTables */
            $('.reportable').DataTable();

            $('.reportable-customer').DataTable({
                'pageLength': 5
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.summernote-lg').summernote({
                placeholder: 'Type your text here',
                tabsize: 2,
                height: 450
            });

            /** dataTables */
            $('.reportable').DataTable();

            $('.reportable-customer').DataTable({
                'pageLength': 5
            });
        });
    </script>

    <script>
        setTimeout(() => {
            $('.check-status').show();
        }, 30000);

        checkStatus = function() {
            $.LoadingOverlay('show');
            $.ajax({
                method: 'post',
                data: 'data=none',
                url: "{{ route('w.u.check.pay.status') }}",
                success: function(data) {
                    $.LoadingOverlay('hide');
                    if (data.hasOwnProperty('Url') && data.hasOwnProperty('Msg')) {
                        $('.alert-success').text(data.Msg);
                        setTimeout(() => {
                            window.location.href = data.Url;
                        }, 3000);
                        return;
                    }
                    if (data.hasOwnProperty('Url')) {
                        window.location.href = data.Url;
                        return;
                    }
                    if (data.hasOwnProperty('Err')) {
                        alert(data.Err);
                        return;
                    }
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay('hide');
                    console.log('ajax errors', xhr, status, error);
                    alert(error);
                }
            });
        }
    </script>

</body>

</html>