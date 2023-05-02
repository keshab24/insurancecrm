@extends('layouts.backend.containerlist')

@section('title')
<p class="h4 align-center mb-0">Social Links</p>
@endsection

@section('dynamicdata')

<div class="box">
    <div class="box-header with-border c-btn-right d-flex-row ">
        <div class="justify-content-end list-group list-group-horizontal ">
            <a href="{{route('social-link.create')}}"><button
                    class="btn btn-primary c-primary-btn add-modal shadow-none mx-2"><img
                        src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> &nbsp; Add New &nbsp;
                </button></a>
        </div>
    </div>
    <div class="box-body px-4">
        <div class="dataTables_wrapper dt-bootstrap4">

            @include('layouts.backend.alert')

            <table id="example1" class="table table-bordered table-hover role-table">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Position</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th class="dt-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="tablebody">

                    @foreach ($links as $index => $link)
                    <tr class="gradeX" id="row_{{ $link->id }}">
                        <td class="index">
                            {{ ++$index }}
                        </td>
                        <td class="name">
                            {{ $link->title }}
                        </td>
                        <td class="name">
                            {{ $link->link }}
                        </td>
                        <td class="name">
                            {{ $link->position }}
                        </td>
                        <td class="name">
                            <i class="{{ $link->icon }}"></i>
                        </td>
                        <td class="name">
                            @if($link->is_active == 0)
                            Inactive
                            @else
                            Active
                            @endif

                        </td>
                        <td class="justify-content-center">
                            <a href="{{route('social-link.edit',$link->id)}}" id="{{ $link->id }}" title="Edit">
                                <button class="btn btn-primary btn-flat">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>&nbsp;

                            <a href="javascript:;" title="Delete" class="delete-link" id="{{ $link->id }}">
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
    $(document).ready(function() {
        var oTable = $('.role-table').dataTable();

        $('#tablebody').on('click', '.delete-link', function(e){
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
                url: "{{ url('social-link') }}"+"/"+id,
                success: function(response){
                    var nRow = $($object).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                    swal('success', response, 'success').catch(swal.noop);
                },
                error: function(e){
                    swal('Oops...', 'Something went wrong!', 'error').catch(swal.noop);
                }
            });
        }).catch(swal.noop);
        });
    });
</script>
@endsection
