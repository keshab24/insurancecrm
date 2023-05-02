@extends('layouts.backend.containerlist')
<?php
// dd($provinces);
// dd($cities);
?>
@section('dynamicdata')
@section('foot_js')
<!-- US state and city -->
<script src="//geodata.solutions/includes/statecity.js"></script>
<script src="{{ asset('backend/plugins/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script>
    ClassicEditor.create(document.querySelector('#description'))
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
<!-- standalone ckeditor image upload -->
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    $('#policy_doc').filemanager('file');
    $('#identity_doc').filemanager('file');
</script>
<!-- standalone ckeditor image upload -->
@endsection
<div class="box">
    <div class="box-header with-border c-btn-right ">
        <button class="btn btn-primary c-primary-btn add-modal "><img
                src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> &nbsp; Leads &nbsp;
            <!-- <i class="fa fa-plus"></i> -->
            <!-- <img class="float-left" src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> -->
        </button>

        <button class="btn btn-default c-primary-btn ">
            <!-- <i class="fa fa-plus"></i> -->
            <img src="{{ asset('uploads/column-regular-16.svg') }}" alt="Add-icon">&nbsp; Columns &nbsp;
            <span class="badge bg-secondary rounded-circle c-number-badge">16</span>
        </button>

        <button class="btn btn-default c-primary-btn ">
            <!-- <i class="fa fa-plus"></i> -->
            <img src="{{ asset('uploads/Action-edit-Regular-16.svg') }}" alt="Add-icon"> &nbsp; Actions &nbsp;
        </button>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        @include('layouts.backend.alert')
        <table id="example1" class="table table-bordered table-striped role-table leads-table">
            <thead>
                <tr>
                    
                   
                    <th>Sales Person Name</th>
                    <th>Customer Name</th>
                    <th>Lead Source</th>
                    <th>Lead Type</th>
		            
                    <th>Phone No.</th>
                    <th>Email </th>
                    <th>Address </th> 
                    <th>Last Updated Date </th>                    
                   
                    <th>Status</th>
                    
                </tr>
                    
                </tr>
            </thead>
            <tbody id="tablebody .table-hover">
           
                <tr>
                    

                    <td>{{ $lead->sales_person_name }}</td>
                    <td>{{ $lead->customer_name }}</td>
                    <td>{{ $lead->leadsource->name }}</td>
                    <td>@isset($lead->leadtype)
                        {{$lead->leadtype->name}}
                      @endisset
                     </td>
                     <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>{{ $lead->address }}</td>
                    <td>{{ $lead->updated_at }}</td>
                    <td>
                        @if($lead->is_active == 1)
                        <small class="label bg-green align-middle">Active</small>
                        @else
                        <small class="label bg-red">Inactive</small>
                        @endif
                    </td>
                   
                </tr>
               
            </tbody>
            <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Sales Person Name</th>
                    <th>Customer Name</th>
                    <th>Phone No.</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>

@endsection

@section('footer_js')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.add-modal', function () {
            $('#addModal').modal('show');
        });
    });


    $(document).ready(function () {
        $(document).on('click', '.edit-modal', function () {
            
            $('.editModal').modal('show');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('.leads-table').dataTable();

        $('#tablebody').on('click', '.delete-leads', function (e) {
            e.preventDefault();
            $object = $(this);
            var id = $object.attr('id');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/admin/leads/') }}" + "/" + id,
                    dataType: 'json',
                    success: function (response) {
                        var nRow = $($object).parents('tr')[0];
                        oTable.fnDeleteRow(nRow);
                        swal('success', response.message, 'success');
                    },
                    error: function (e) {
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });
        });

        $('.close').on('click', function () {
            $('div.modal.show').removeClass("show");
            $('body').removeClass("modal-open");
            $('div.modal-backdrop').removeClass("modal-backdrop");
            $('div.modal.fade').css("display", "none");
        });
    });
</script>

{{-- <script src="http://code.jquery.com/jquery-3.4.1.js"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $('#province').on('change', function () {
            let id = $(this).val();
            $('#city').empty();
            $('#city').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: 'getCityList/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#city').empty();
                    $('#city').append(
                        `<option value="0" disabled selected>Select City</option>`);
                    response.forEach(element => {
                        $('#city').append(
                            `<option value="${element['id']}">${element['city_name']}</option>`
                        );
                    });
                }
            });
        });
    });
</script>

@endsection