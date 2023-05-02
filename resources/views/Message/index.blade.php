@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Messages</p>
@endsection

@section('dynamicdata')

    <div class="box">
        <div class="box-body">
            <div class="dataTables_wrapper dt-bootstrap4">

                @include('layouts.backend.alert')

                <table id="example1" class="table table-bordered table-hover role-table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Full Name</th>
                            <th>E-Mail</th>
                            <th>Message</th>
                            <th class="dt-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">

                        @foreach ($messages as $index => $message)
                            <tr class="gradeX" id="row_{{ $message->id }}">
                                <td class="index">
                                    {{ ++$index }}
                                </td>
                                <td class="name">
                                    {{ $message->name }}
                                </td>
                                <td class="name">
                                    {{ $message->email }}
                                </td>
                                <td class="name">
                                    {{ $message->message }}
                                </td>
                                <td class="justify-content-center">

                                    <a href="{{ route('admin.message.show', $message->id) }}" id="{{ $message->id }}"
                                        title="Show message"><button class="btn btn-primary btn-flat"><i
                                                class="fa fa-eye"></i></button></a>&nbsp;

                                    <a href="javascript:;" title="Delete message" class="delete-messages"
                                        id="{{ $message->id }}"><button type="button" class="btn btn-danger btn-flat"><i
                                                class="fa fa-trash"></i></button></a>

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
        $(document).ready(function() {
            var oTable = $('.role-table').dataTable();

            $('#tablebody').on('click', '.delete-messages', function(e) {
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
                }).then(function() {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('messages/delete') }}" + "/" + id,
                        dataType: 'json',
                        success: function(response) {
                            var nRow = $($object).parents('tr')[0];
                            oTable.fnDeleteRow(nRow);
                            swal('success', response.message, 'success').catch(swal
                                .noop);
                        },
                        error: function(e) {
                            swal('Oops...', 'Something went wrong!', 'error').catch(swal
                                .noop);
                        }
                    });
                }).catch(swal.noop);
            });
        });

    </script>
@endsection
