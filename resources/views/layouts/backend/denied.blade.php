@extends('layouts.backend.container')

@section('footer_js')
    <script type="text/javascript">
      $(document).ready(function(){
        $('.sidebar-menu li').removeClass('active');
      });
    </script>
@endsection

@section('dynamicdata')

<!-- Main content -->
<div class="content body pl-4">
  <section id="introduction">
    <h2 class="page-header">Error! Access Denied</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-body">
                        <p><strong> An error has occurred while processing your request.</strong></p>
                        <p>This may occurred because there was an attempt to manipulate this software or
                            you have not enough permission to process this request.</p>
                        <p>If you have not enough permission, you can request to your system administrator to get
                            additional access.</p>
                        <p>Users are prohibited from taking unauthorized actions to intentionally modify the system.</p>
                    </div>
                </div>
            </div>
        </div>
  </section>
</div>

@stop
