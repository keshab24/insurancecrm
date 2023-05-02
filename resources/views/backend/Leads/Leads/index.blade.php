@extends('layouts.backend.containerlist')
<?php
// dd($provinces);
// dd($cities);
?>
@section('title')
    <p class="h4 align-center mb-0">Leads</p>
@endsection
<style>
    /*Right*/
    .modal.right.fade .modal-dialog {
        right: 0px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }
    .form-group label {
        color: #8A8A8A;
        font-weight: 500;
        font-size: 16px;
    }
</style>
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
    <div class="box-header with-border c-btn-right d-flex-row ">
        {{-- <div class="c-table-search c-primary--search">
            <form class="form-inline d-flex-inline">
                <img src="{{ asset('uploads/search-24.svg') }}" alt="Menu-collapse">
        <input class="form-control form-control-sm ml-3 w-75" type="text"
            placeholder="Search Leads, Customer, Leads type..." aria-label="Search">
        </form>
    </div> --}}
        <div class="justify-content-end list-group list-group-horizontal ">
            <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal"
                    data-target="#addModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon">
                &nbsp;
                Leads &nbsp;
                <!-- <i class="fa fa-plus"></i> -->
            <!-- <img class="float-left" src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> -->
            </button>

            <button class="btn btn-default c-primary-btn shadow-none mx-2 ">
                <!-- <i class="fa fa-plus"></i> -->
                <img src="{{ asset('uploads/column-regular-16.svg') }}" alt="Add-icon">&nbsp; Columns &nbsp;
                <span class="badge bg-secondary rounded-circle c-number-badge">16</span>
            </button>

            <button class="btn btn-default c-primary-btn shadow-none mx-2">
                <!-- <i class="fa fa-plus"></i> -->
                <img src="{{ asset('uploads/Action-edit-Regular-16.svg') }}" alt="Add-icon"> &nbsp; Actions &nbsp;
            </button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        @include('layouts.backend.alert')
        <table id="example1" class="table table-bordered table-striped role-table leads-table">
            <thead class="text-nowrap">
            <tr>
                <th>SN</th>
                <th>Sales Person Name</th>
                <th>Customer Name</th>
                <th>Profession</th>
                <th>Address</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Lead Source</th>
                <th>Lead Type</th>
                <th>Policy Category</th>
                <th>Policy Sub-Category</th>
                <th>Policy type</th>
                <th>Maturity Amount</th>
                <th>Maturity Period</th>
                <th>Remarks</th>
                <th>Meetings</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="tablebody">
            @foreach($leads as $lead)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lead->sales_person_name }}</td>
                    <td>{{ $lead->customer_name }}</td>
                    <td>{{ $lead->profession }}</td>
                    <td>@isset($lead->leadsource){{ $lead->address }} @endisset</td>
                    <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>@isset($lead->leadsource){{ $lead->leadsource->name }} @endisset</td>
                    <td>
                        @isset($lead->leadtype)
                            {{$lead->leadtype->type}}
                        @endisset
                    </td>
                    <td>
                        @if($lead->policy_cat==1)
                            <p>Life</p>
                        @else
                            <p>Non Life</p>
                        @endif
                    </td>
                    <td>
                        @isset($lead->policy_sub_cat){{ $lead->policy_subcat->subcat_name }} @endisset
                    </td>
                    <td>
                        @isset($lead->policytype)
                            {{ $lead->policytype->type }} @endisset
                    </td>
                    <td>
                        {{$lead->sun_insured}}
                    </td>
                    <td>
                        {{$lead->maturity_period}}
                    </td>
                    <td>
                        @forelse ($lead->events()->orderBy('created_at','desc')->take(1)->get() as $remark)
                            <p>
                                {{$remark->title}}</p> <a href="javascript:void(0);" class="remarkbutton"
                                                          title="Add remarks" data-lead_id="{{$lead->id}}"
                                                          data-customer_name="{{$lead->customer_name}}"
                                                          data-target="#remarkModal" data-toggle="modal">
                                Update</a>
                        @empty
                            <p>No remarks.</p> <a href="javascript:void(0);" title="Add remarks" class="remarkbutton"
                                                  data-lead_id="{{$lead->id}}" data-remarks="{{$lead->remarks}}"
                                                  data-customer_name="{{$lead->customer_name}}"
                                                  data-target="#remarkModal"
                                                  data-toggle="modal">Add one..</a>
                        @endforelse
                    </td>
                    <td>
                        @forelse ($lead->meetings()->orderBy('created_at','desc')->take(1)->get() as $remark)
                            <p>
                                {{$remark->title}}</p> <a href="javascript:void(0);" class="meetingbutton"
                                                          title="Add remarks" data-lead_id="{{$lead->id}}"
                                                          data-target="#meetingModal" data-toggle="modal">Update</a>
                        @empty
                            <p>No meeting sheduled.</p> <a href="javascript:void(0);" title="Add meetings"
                                                           class="meetingbutton" data-lead_id="{{$lead->id}}"
                                                           data-target="#meetingModal"
                                                           data-toggle="modal">Add one..</a>
                        @endforelse
                    </td>
                    <td>
                        <a href="javascript:;" title="Edit Lead" class="edit-modal">
                            <button class="btn btn-primary btn-sm" data-lead_id="{{$lead->id}}"
                                    data-sales_person_name="{{$lead->sales_person_name}}"
                                    data-customer_name="{{$lead->customer_name}}" data-phone="{{$lead->phone}}"
                                    data-email="{{$lead->email}}" data-profession="{{$lead->profession}}"
                                    data-insurence="{{$lead->insurence_company_name}}"
                                    data-policy_cat="{{$lead->policy_cat}}"
                                    data-policy_sub_cat="{{$lead->policy_sub_cat}}"
                                    data-policy_type="{{$lead->policy_type}}" data-sun="{{$lead->sun_insured}}"
                                    data-maturity="{{$lead->maturity_period}}" data-premium="{{$lead->premium}}"
                                    data-transfer="{{$lead->lead_transfer_req}}" data-dob="{{$lead->dob}}"
                                    data-street_ward="{{$lead->street_ward}}"
                                    data-leadsource_id="{{$lead->leadsource_id}}"
                                    data-note="{{$lead->note}}" data-province_id="{{$lead->province_id}}"
                                    data-leadtype_id="{{isset($lead->leadtype->id)}}"
                                    data-is_active="{{$lead->is_active}}"
                                    data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></button>&nbsp;
                            <a href="javascript:;" title="Delete leadsource" class="delete-leadsource"
                               id="{{ $lead->id }}">
                                <button class="btn btn-danger btn-sm btn-flat"><i
                                        class="fa fa-trash"></i></button>
                            </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>SN</th>
                <th>Sales Person Name</th>
                <th>Customer Name</th>
                <th>Profession</th>
                <th>Address</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Lead Source</th>
                <th>Lead Type</th>
                <th>Policy Category</th>
                <th>Policy Sub-Category</th>
                <th>Policy type</th>
                <th>Maturity Amount</th>
                <th>Maturity Period</th>
                <th>Remarks</th>
                <th>Meeting</th>
                <th>Options</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- Modal form to add a leads -->
<section class=" container">
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content leads-customer__wrapper">
                <div class="modal-header modal--header d-flex">
                    <h4 class="modal-title">Add Leads</h4>
                </div>
                <section class="leads-form-section">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Documents</a>
                        </li>
                    </ul>
                @include('Backend.Leads.Leads._addleadmodule')
            </div>

        </div>
    </div>
</section>
</div>

</section>
<!-- Modal form to edit a leads -->
<section class=" container">
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content leads-customer__wrapper">
                <div class="modal-header modal--header d-flex">
                    <h4 class="modal-title">Edit Leads</h4>
                </div>

                <section class="leads-form-section">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Documents</a>
                        </li>
                    </ul>
                @include('Backend.Leads.Leads._editleadmodule')
            </div>

        </div>

    </div>
    </div>
</section>

<section class="container">
    <!-- Modal form to add a Remarks -->
    @include('Backend.Leads.Leads._remarksmodule')
    @include('Backend.Leads.Leads._meetingmodule')
</section>

@endsection

@section('footer_js')
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example1 tfoot th:gt(0)').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + title + '" />');
            });

            // DataTable
            var table = $('#example1').DataTable({
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every(function () {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                },
                "scrollX": true,
                scrollY: '70vh',
                scrollCollapse: true,
                paging: true
            });

        });

        $(document).ready(function () {
            $('.example1').DataTable({});
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.add-modal', function () {
                $('#addModal').modal('show');
            });
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var lead_id = button.data('lead_id')
                var sales_person_name = button.data('sales_person_name')
                var customer_name = button.data('customer_name')
                var phone = button.data('phone')
                var dob = button.data('dob')
                var email = button.data('email')
                var note = button.data('note')
                var profession = button.data('profession')
                var insurence = button.data('insurence')
                var street_ward = button.data('street_ward')
                var leadsource = button.data('leadsource_id')
                var province = button.data('province_id')
                var leadtype = button.data('leadtype_id')
                var policy_type = button.data('policy_type')
                var sun = button.data('sun')
                var maturity = button.data('maturity')
                var premium = button.data('premium')
                var transfer = button.data('transfer')
                var policy_cat = button.data('policy_cat')
                var policy_sub_cat = button.data('policy_sub_cat')
                var is_active = button.data('is_active')
                var policy_cat_id = button.data('policy_cat_id')
                var modal = $(this)
                modal.find('.form-horizontal #lead_id').val(lead_id);
                modal.find('.tab-pane #sales_person_name').val(sales_person_name);
                modal.find('.tab-pane #customer_name').val(customer_name);
                modal.find('.tab-pane #phone').val(phone);
                modal.find('.tab-pane #email').val(email);
                modal.find('.tab-pane #dob').val(dob);
                modal.find('.tab-pane #note').val(note);
                modal.find('.tab-pane #profession').val(profession);
                modal.find('.tab-pane #insurence').val(insurence);
                modal.find('.tab-pane #sun').val(sun);
                modal.find('.tab-pane #maturity').val(maturity);
                modal.find('.tab-pane #premium').val(premium);
                modal.find('.tab-pane #transfer').val(transfer);
                modal.find('.tab-pane #policy_type').val(policy_type);
                modal.find('.tab-pane #street_ward').val(street_ward);
                modal.find('.tab-pane #leadsource_id').val(leadsource);
                modal.find('.tab-pane #province_id').val(province);
                modal.find('.tab-pane #leadtype_id').val(leadtype);
                modal.find('.tab-pane #policy_cat').val(policy_cat);
                modal.find('.tab-pane #policy_sub_cat').val(policy_sub_cat);
                modal.find('.tab-pane #is_active').val(is_active);
                modal.find('.tab-pane #policy_cat_id').val(policy_cat_id);
            });
        });


        $(document).ready(function () {
            $(document).on('click', '.edit-modal', function () {
                $('#editModal').modal('show');
            });
        });
    </script>

    <script type="text/javascript">
        $('#remarkModal').on('show.bs.modal', function (event) {

            var lead_id = $(event.relatedTarget).data('lead_id')
            var customer_name = $(event.relatedTarget).data('customer_name')
            var remark = $(event.relatedTarget).data('remark')
            var remarks = $(event.relatedTarget).data('remarks')


            var modal = $(this)

            modal.find('.modal-body #name').val(customer_name);
            modal.find('.modal-body #lead_id').val(lead_id);
            modal.find('.modal-body #remark').val(remark);
            modal.find('.modal-body #remarks').text('Previous Remarks: ' + JSON.stringify(remarks));

        })

        $('#meetingModal').on('show.bs.modal', function (event) {

            var lead_id = $(event.relatedTarget).data('lead_id')

            var topic = $(event.relatedTarget).data('topic')


            var modal = $(this)


            modal.find('.modal-body #lead_id').val(lead_id);
            modal.find('.modal-body #topic').val(topic);


        })
    </script>

    <script>
        ClassicEditor.create(document.querySelector('#remark'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('.remarkbutton').click(function (e) {
                e.preventDefault();
                $('#listremarks').html('');
                var id = $(this).data('lead_id');
                $('#loading-image').show();
                $.ajax({
                    url: "{{ url('admin/lead/getleadremarks') }}" + "/" + id,
                    type: 'GET',
                    success: function (response) {
                        $('#listremarks').html(response);
                        $('#remarkModal').modal().show();
                    },
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.meetingbutton').click(function (e) {
                e.preventDefault();
                $('#listmeetings').html('');
                var id = $(this).data('lead_id');

                $.ajax({
                    url: "{{ url('admin/lead/getleadmeetings') }}" + "/" + id,
                    type: 'GET',
                    success: function (response) {
                        $('#listmeetings').html(response);
                        $('#meetingModal').modal().show();
                    },
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var oTable = $('.leads-table').dataTable();

            $('#tablebody').on('click', '.delete-leadsource', function (e) {
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
        $('form-add-leads').on('scroll', function () {
            alert('scrolled');
        })
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
    <script>
        $(function () {

            $("#editModal").validate({
                rules: {
                    sales_person_name: {
                        required: true,
                        minlength: 3
                    },
                    action: "required"
                },
                messages: {
                    sales_person_name: {
                        required: "Please enter some data",
                        minlength: "Your data must be at least 8 characters"
                    },
                    action: "Please provide some data"
                }
            });
        });
        $(".alert-success, .alert-warning").fadeTo(2000, 500).slideUp(500, function () {
            $(".alert-successt").slideUp(500);
        });
    </script>
@endsection
