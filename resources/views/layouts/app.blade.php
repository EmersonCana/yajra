<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{secure_asset('asset/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{secure_asset('asset/css/main.css')}}">
    <link href="{{secure_asset('/asset/now-ui/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{secure_asset('/asset/now-ui/demo/demo.css')}}" rel="stylesheet" />

    <!-- DataTables -->
    <link href="{{secure_asset('/asset/DataTables/css/jquery.dataTables.css')}}" rel="stylesheet" />
</head>
<body class="">
    <div class="wrapper ">
        <main>
            @yield('content')
        </main>
    </div>

    <!--   Core JS Files   -->
    <script src="{{secure_asset('/asset/now-ui/js/core/jquery.min.js')}}"></script>
    <script src="{{secure_asset('/asset/now-ui/js/core/popper.min.js')}}"></script>
    <script src="{{secure_asset('/asset/now-ui/js/core/bootstrap.min.js')}}"></script>
    <script src="{{secure_asset('/asset/now-ui/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
    <!-- DivJs -->
    <script src="{{secure_asset('/asset/js/divjs/divjs.js')}}"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="{{secure_asset('/asset/now-ui/js/plugins/chartjs.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{secure_asset('/asset/now-ui/js/plugins/bootstrap-notify.js')}}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{secure_asset('/asset/now-ui/js/now-ui-dashboard.min.js?v=1.5.0')}}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    
    <!-- DataTables -->
    <script src="{{secure_asset('/asset/DataTables/js/jquery.dataTables.js')}}"></script>
    <script>
        
    
                                
        $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        });
        
        
        $('#employees_table').DataTable();

        $('employee_records').hide();
        $('employee_payroll').hide();

        $('#list_employee').click( () => {
            $('#list_employee').addClass('active');
            $('#list_record').removeClass('active');
            $('#list_payroll').removeClass('active');
            if($('#list_employee').hasClass('active')) {
                $('employee_list').show();
                $('employee_records').hide();
                $('employee_payroll').hide();
            }
        });

        $('#list_records').click( () => {
            $('#list_employee').removeClass('active');
            $('#list_records').addClass('active');
            $('#list_payroll').removeClass('active');
            if($('#list_records').hasClass('active')) {
                $('employee_list').hide();
                $('employee_records').show();
                $('employee_payroll').hide();
            }
        });

        $('#list_payroll').click( () => {
            $('#list_employee').removeClass('active');
            $('#list_records').removeClass('active');
            $('#list_payroll').addClass('active');
            if($('#list_payroll').hasClass('active')) {
                $('employee_list').hide();
                $('employee_records').hide();
                $('employee_payroll').show();
            }
        });

        $('#hidden-date').hide();
        $('#edit-date').click( () => {
            $('#hidden-date').slideToggle();
        });

        $('#success').fadeOut(3000);
        
       
    </script>
</body>
</html>
