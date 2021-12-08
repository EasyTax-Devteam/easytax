
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
    <style>
        .app-branding .logo-icon {
            width: 120px;
            height: auto;
        }
        .tiny{
            font-size: 8px!important;
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
	    </footer><!--//app-footer-->

    </div><!--//app-wrapper-->    					

 
    <!-- Javascript -->          
    <script src="{{ asset('auth/assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('auth/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>  

    <!-- Charts JS -->
    <script src="{{ asset('auth/assets/plugins/chart.js/chart.min.js') }}"></script> 
    <script src="{{ asset('auth/assets/js/index-charts.js') }}"></script> 
    
    <!-- Page Specific JS -->
    <script src="{{ asset('auth/assets/js/app.js') }}"></script> 

</body>
</html> 