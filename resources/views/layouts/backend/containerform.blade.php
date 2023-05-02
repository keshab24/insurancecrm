<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{!!  csrf_token() !!}"/>
    <title>Dashboard | {!! env('APP_NAME') !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
<!-- Bootstrap 3.3.7
  <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.in.css')}} ">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{ asset('backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
          href="{{ asset('backend/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
               folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/skins/_all-skins.min.css') }}">

    <link rel="stylesheet" type="text/css"
          href="{!! asset('backend/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link
        href="{{ asset('backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet"
    />

    <!-- Colorpicker Css -->
    <link href="{{ asset('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet"/>

    <!-- formValidation -->
    <link href="{{ asset('backend/js/formValidation/formValidation.min.css') }}" rel="stylesheet">

    <!-- sweet alert -->
    <link href="{{ asset('backend/js/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Font CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css')}}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{!! asset('css/backend-style.css')!!}"/>

    <!-- Dropzone style -->
    <link rel="stylesheet" href="{!! asset('backend/css/dropzone.css') !!}">
    <link rel="stylesheet" href="{!! asset('backend/css/custom.css') !!}">

    <!-- Nepali Datepicker CSS -->
    <link href="{{asset('css\nepali.datepicker.v3.7.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- datetime picker -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">

    <!-- jQuery 3 for tagselect  -->
    <link rel="stylesheet" href="{!! asset('backend/css/jquery.tagselect.css') !!}">

    <script>
        var rootUrl = '{!! url('') !!}';
    </script>

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">

    @yield('header_css')

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div id="preloader" style="display: none;">
    <div id="loader"></div>
</div>
<div class="wrapper">

@include('layouts.backend.header')

@include('layouts.backend.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-top:50px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @include('layouts.backend.breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('dynamicdata')

        </section>
        <!-- /.content -->
    </div>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Google Translator -->
{{-- <script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ne'}, 'google_translate_element');
  }
</script> --}}

<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<!-- jQuery 3 -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery 3 for tagselect  -->
<script src="{{ asset('backend/plugins/tagselect/jquery.tagselect.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('backend/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('backend/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- bootstrap color picker -->
<script
    src="{{ asset('backend/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('backend/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/dist/js/demo.js') }}"></script>

<!--bootstrap-fileupload-->
<script type="text/javascript" src="{!! asset('backend/js/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script
    src="{{ asset('backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Nepali Datetime Js -->
<script src="{{asset('js\nepali.datepicker.v3.7.min.js')}}" type="text/javascript"></script>

<!-- Bootstrap Colorpicker Js -->
<script src="{{ asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>

<!--ckeditor-->
<script src="{{ asset('backend/js/ckeditor/ckeditor.js') }}"></script>
<script src="//cdn.ckeditor.com/4.4.3/basic/adapters/jquery.js"></script>

<!-- formValidation -->
<script src="{{ asset('backend/js/formValidation/formValidation.min.js') }}"></script>
<script src="{{ asset('backend/js/formValidation/bootstrap.min.js') }}"></script>

<!-- Dropzone js -->
<script src="{!! asset('backend/js/dropzone.js') !!}"></script>
<script src="{!! asset('backend/js/dropzone-config.js') !!}"></script>

<!-- sweet alert -->
<script src="{{ asset('backend/js/sweetalert/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('backend/plugins/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<!--custom scripts -->
<script src="{{ asset('backend/js/onload.js') }}"></script>


<!-- datetime picker -->
<script language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>


@yield('footer_js')
{{-- <script type="text/javascript">
  //Date picker
  $('#datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    showOnFocus: true,
    daysOfWeekHighlighted: "6",
  })
</script> --}}

<script>
    $(document).ready(function () {
        $('.datepick').datetimepicker({
            //        stepping: 30,
            //  enabledHours: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            // format: 'yyyy-mm-dd hh:mm:ss',
            format: 'YYYY-MM-DD HH:mm A',

            // controlType: 'slider'
        });
    });
    $(".custom-file-input").on("change", function (event) {
        var tmppath = URL.createObjectURL(event.target.files[0]);
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        $(this).siblings(".custom-file-image").empty().append('<img style="max-width: 50%; margin-top: 10px;" src="' + tmppath + '">');
    });
    $('#NCDYR').on('change', function () {
        $('.ncd-check-btn').addClass('d-none').empty();
        if ($(this).val() > 0) {
            $('.ncd-check-btn').removeClass('d-none').append('<div class="form-check">\n' +
                '<input type="checkbox" class="form-check-input" title="You have to accept if you have the NCD Year" id="ncdCheck" required>\n' +
                '<label class="form-check-label" for="ncdCheck">I thereby accept to bear the consequences if found guilty on No Claim Discount (NCD Year) .</label> <span class="badge badge-success p-2">' + $(this).val() + ' Year</span>\n' +
                '</div>');
        }
    });
    $(document).ready(function () {
        $('.nepali-datepicker').nepaliDatePicker({
            ndpYear: true,
            ndpMonth: true,
            ndpEnglishInput: 'english-date'
        });
    });

    $(document).ready(function () {
        $('.search-selection').select2();
    });

</script>
</body>

</html>

