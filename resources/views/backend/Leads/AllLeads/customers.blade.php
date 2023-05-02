@extends('layouts.backend.containerlist')
<?php
// dd($provinces);
// dd($cities);
?>
@section('title')
    <p class="h4 align-center mb-0">Customers</p>
@endsection
<style>
    .modal.left .modal-dialog {
        position: fixed;
        right: 0;
        margin: auto;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    .modal.right.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.right.fade.show .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #eeeeee;
        background-color: #fafafa;
    }

    /* ----- v CAN BE DELETED v ----- */
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .action-btn {
        padding: 10px !important;
        height: 100% !important;
    }
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

@section('footer_js')
    <!-- formValidation -->
    <script src="{{ asset('backend/js/formValidation/formValidation.min.js') }}"></script>
    <script src="{{ asset('backend/js/formValidation/bootstrap.min.js') }}"></script>

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
        // $(document).ready(function () {}
        $(document).on('click', '.add-modal', function () {
            $('#addModal').modal('show');
            $('.modal-title').text('Add Customer');
            $('.lower-form-contents').html(null).addClass('d-none');
            $('#leadAddEdit').append('<input type="hidden" name="is_user" id="is_user" value="1">');
        });
        $(".edit-modal").on("click", function (e) {
            $('#addModal').modal('show');
            $('.modal-title').text('Edit Customer');
            $('.lower-form-contents').html(null).addClass('d-none');
            $('#leadAddEdit').attr('action', "{{ route('admin.lead.update')}}");
            var button = $(this);
            var lead_id = button.data('lead_id');
            // console.log(lead_id);
            var sales_person_name = button.data('sales_person_name');
            var customer_name = button.data('customer_name');
            var phone = button.data('phone');
            var dob = button.data('dob');
            var email = button.data('email');
            var note = button.data('note');
            var profession = button.data('profession');
            var insurence = button.data('insurence');
            var street_ward = button.data('street_ward');
            var leadsource = button.data('leadsource_id');
            var province = button.data('province_id');
            var leadtype = button.data('leadtype_id');
            var policy_type = button.data('policy_type');
            var sun = button.data('sun');
            var maturity = button.data('maturity');
            var premium = button.data('premium');
            var transfer = button.data('transfer');
            var policy_cat = button.data('policy_cat');
            var policy_sub_cat = button.data('policy_sub_cat');
            var is_active = button.data('is_active');
            var policy_cat_id = button.data('policy_cat_id');
            var modal = $('#addModal');
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
    </script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#tablebody').on('click', '.delete-lead', function (e) {
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
@endsection

@section('dynamicdata')
    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
                <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal"
                        data-target="#addModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon">
                    Add Customer
                </button>
                <button class="btn btn-default c-primary-btn shadow-none mx-2 d-none">
                    <!-- <i class="fa fa-plus"></i> -->
                    <img src="{{ asset('uploads/column-regular-16.svg') }}" alt="Add-icon">&nbsp; Columns &nbsp;
                    <span class="badge bg-secondary rounded-circle c-number-badge">16</span>
                </button>

                <button class="btn btn-default c-primary-btn shadow-none mx-2 d-none">
                    <!-- <i class="fa fa-plus"></i> -->
                    <img src="{{ asset('uploads/Action-edit-Regular-16.svg') }}" alt="Add-icon"> &nbsp; Actions &nbsp;
                </button>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <form action="" enctype="multipart/form-data">
                        <div class="input-group rounded col-md-6">
                            <input type="search" name="search" class="form-control rounded" placeholder="Search Customers"
                                   aria-label="Search"
                                   aria-describedby="search-leads" value="{{request()->search ?? ''}}"/>
                            <button type="search-button" type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.backend.alert')
            <table id="leadLists" class="table table-bordered table-striped role-table leads-table">
                <thead class="text-nowrap">
                <tr>
                    <th>SN</th>
                    <th>Sales Person Name</th>
                    <th>Customer Name</th>
                    <th>Profession</th>
                    <th>Address</th>
                    <th>Phone No.</th>
                    <th>Email</th>
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
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->sales_person_name }}</td>
                        <td>{{ $lead->customer_name }}</td>
                        <td>{{ $lead->profession }}</td>
                        <td>@isset($lead->leadsource){{ $lead->address }} @endisset</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->email }}</td>
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
                                <p>No remarks.</p> <a href="javascript:void(0);" title="Add remarks"
                                                      class="remarkbutton"
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
                            <a href="{{route('customer.kyc',$lead->id)}}" data-toggle="tooltip"
                               data-placement="top" title="Create Customer KYC"
                               class="btn btn-primary btn-sm action-btn mr-2">
                                <i class="fa fa-user"></i>
                            </a>
                            <button id="leadEdit" title="Edit Lead" class="btn btn-primary btn-sm edit-modal action-btn"
                                    data-lead_id="{{$lead->id}}"
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
                                    data-is_active="{{$lead->is_active}}"><i class="fa fa-edit"></i></button>&nbsp;
                            <a href="javascript:;" title="Delete leadsource"
                               class="btn btn-danger delete-lead btn-sm action-btn"
                               id="{{ $lead->id }}"><i class="fa fa-trash"></i>
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

        <div class="d-flex justify-content-center">
            {!! $leads->links() !!}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- Modal form to add a leads -->
    @include('Backend.Leads.Leads._addleadmodule')
@endsection
