@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Api Keys</p>
@endsection

@section('dynamicdata')

    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
                <a href="{{route('api-key.create')}}">
                    <button
                        class="btn btn-primary c-primary-btn add-key shadow-none mx-2"><img
                            src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> &nbsp; Add New Key
                        &nbsp;
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
                        <th>SN</th>
                        <th>Key</th>
                        <th class="dt-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">

                    @foreach ($apiKeys as $index => $setting)
                        <tr class="gradeX" id="row_{{ $setting->id }}">
                            <td class="index">
                                {{ ++$index }}
                            </td>
                            <td class="name">
                                {{ $setting->api_key }}
                            </td>
                            <td class="justify-content-center">
                                <a href="javascript:;" title="Delete" class="delete-setting" id="{{ $setting->id }}">
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
        document.querySelector('.add-key').onclick = function(e){
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "To add a key!",
                type: "question",
                showCancelButton: true,
                confirmButtonText: 'ok',
                cancelButtonText: 'cancel',
                allowOutsideClick: false
            }).then((result) => {
                if (result.dismiss !== 'cancel') {
                    location.href="/api-key/create";
                }
            })
        };
        $(document).ready(function () {
            var oTable = $('.role-table').dataTable();

            $('#tablebody').on('click', '.delete-setting', function (e) {
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
                        url: "{{ url('api-key') }}" + "/" + id,
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
