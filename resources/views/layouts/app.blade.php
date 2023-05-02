<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/square/blue.css') }}">

    <!-- Custom style file  -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">

    <!-- Google Font -->
    <!-- /custom google font style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>
    /*password*/
    .input-group-addon {
        padding: .5rem .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.25;
        color: #495057;
        text-align: center;
        background-color: #e9ecef;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .25rem;
    }
    .input-group-addon, .input-group-btn {
        white-space: nowrap;
        vertical-align: middle;
    }
    .input-group .form-control, .input-group-addon, .input-group-btn {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
    }
</style>
</head>

<body class="container-fluid admin--login--wrapper">
<!-- <div class="row" style="border: 2px solid blue"> -->
@yield('content')


<!-- jQuery 3 -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>


<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>

<!-- toggle hide show password -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/hideshowpassword/2.0.8/hideShowPassword.min.js"></script>

@yield('script')
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
        $("[data-toggle=tooltip").tooltip();
    });
</script>
</body>

</html>
