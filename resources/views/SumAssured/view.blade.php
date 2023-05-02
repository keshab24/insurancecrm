@extends('layouts.backend.containerlist')

@section('footer_js')
<script>
    $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
</script>
@endsection
@section('title')
<p class="h4 align-center mb-0">Discount Sum Assured</p>
@endsection

@section('dynamicdata')

<div class="box">
    <div class="box-header with-border c-btn-right d-flex-row ">
        <div class="justify-content-end list-group list-group-horizontal ">
            <a href="{{route('admin.discount.create')}}">
                <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal"
                    data-target="#addNewUserModal">
                    &nbsp; Add New &nbsp;
                </button>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper dt-bootstrap4">
            <div class="box-body">

                @include('layouts.backend.alert')

                <table id="example1" class="table table-bordered table-hover role-table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Start Amount</th>
                            <th>End Amount</th>
                            <th>Discount Rate</th>
                            <th>Company Name</th>
                            <th>Product name</th>

                            <th width="220px">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">

                        @foreach($discount as $index=>$dis)
                        <tr class="gradeX" id="row_{{ $dis->id }}">
                            <td class="index">
                                {{ ++$index }}
                            </td>
                            <td class="name">
                                {{ $dis->first_amount }}
                            </td>
                            <td class="name">
                                {{ $dis->second_amount }}
                            </td>
                            <td class="name">
                                {{ $dis->discount_value }}
                            </td>
                            <td class="name">
                                @if($dis->company_id)
                                {{ $dis->company->name }}
                                @endif
                            </td>
                            <td class="name">
                                @if($dis->product_id)
                                {{ $dis->product->name ?? 'N/A' }}
                                @endif
                            </td>

                            <td class="justify-content-center">
                                <a href="discountEdit/{{$dis->id}}" id="{{ $dis->id }}" title="Edit ">
                                    <button class="btn btn-primary btn-flat">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>&nbsp;
                                <a href='discountList/{{  $dis->id }}' class="delete-discount"
                                    onclick="return confirm('Are you sure you want to Delete?');">
                                    <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i>
                                    </button>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->

            <!-- /.box -->
            @endsection
        </div>
    </div>
</div>
@section('footer_js')
<script type="text/javascript">
    $(document).ready(function () {
            var oTable = $('.role-table').dataTable();

            $('#tablebody').on('click', '.delete-discount', function (e) {
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
                        url: "{{ url('discountList') }}" + "/"id,
                        dataType: 'json',
                        success: function (response) {
                            var nRow = $($object).parents('tr')[0];
                            oTable.fnDeleteRow(nRow);
                            swal('success', response.message, 'success').catch(swal.noop);
                        },
                        error: function (e) {
                            swal('Oops...', 'Something went wrong!', 'error').catch(swal.noop);
                        }
                    });
                }).catch(swal.noop);
            });
        });
</script>
@endsection
