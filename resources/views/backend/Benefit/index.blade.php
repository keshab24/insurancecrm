@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Benefits</p>
@endsection

@section('dynamicdata')

    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
                <a href="{{route('benefit.create')}}">
                    <button
                        class="btn btn-primary c-primary-btn add-modal shadow-none mx-2"><img
                            src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> &nbsp; Add New &nbsp;
                    </button>
                </a>
            </div>
        </div>
        <div class="box-body px-4">
            <div class="dataTables_wrapper dt-bootstrap4">

                @include('layouts.backend.alert')

                <table id="example1" class="table table-bordered table-hover role-table">
                    <thead>
                    <tr>
                        <th>Benefit Name</th>
                        <th>Category</th>
                        <th>Company</th>
                        <th class="dt-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">

                    @foreach ($benefits as $index => $benefit)
                        <tr class="gradeX" id="row_{{ $benefit->id }}">
                            <td class="name">
                                {{ $benefit->name }}
                            </td>
                            <td class="name text-capitalize">
                                {{ $benefit->category }}
                            </td>
                            <td class="name">
                                {{ $benefit->company->name }}
                            </td>
                            <td class="justify-content-center">
                                <a href="{{route('benefit.edit', $benefit->id)}}" id="{{ $benefit->id }}"
                                   title="Edit">
                                    <button class="btn btn-primary btn-flat">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>&nbsp;

                                <a href="javascript:;" title="Delete" class="delete-benefit" id="{{ $benefit->id }}">
                                    <button type="button" class="btn btn-danger btn-flat">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script type="text/javascript">
        $(document).ready(function () {
            var oTable = $('.role-table').dataTable();

            $('#tablebody').on('click', '.delete-benefit', function (e) {
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
                        url: "{{ url('benefit') }}" + "/" + id,
                        success: function (response) {
                            var nRow = $($object).parents('tr')[0];
                            oTable.fnDeleteRow(nRow);
                            swal('success', response, 'success').catch(swal.noop);
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
