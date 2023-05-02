@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Our Associations</p>
@endsection

@section('header_css')
    <style>
        .img-responsive {
            max-width: 100%;
        }
    </style>
@endsection
@section('footer_js')
    <script type="text/javascript">
        var oTable = $('#attTable').dataTable();
        $('#tablebody').on('click', '.delete-item', function (e) {
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
                    type: "POST",
                    url: "{{ url('/association') }}" + "/" + id,
                    data: {
                        'id': id,
                        _method: 'delete'
                    },
                    dataType: 'json',
                    success: function (response) {
                        var nRow = $($object).parents('tr')[0];
                        oTable.fnDeleteRow(nRow);
                        swal('Success', response.message, 'success');
                    },
                    error: function (e) {
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });
        });

        $('#tablebody').on('click', '.change-status', function (e) {
            e.preventDefault();
            $object = $(this);
            var id = $object.attr('id');
            swal({
                title: 'Are you sure?',
                text: "You are going to change the status!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then(function () {
                $.ajax({
                    type: "POST",
                    url: "{{ url('association/status') }}" + "/" + id,
                    data: {
                        'id': id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        swal('Success', response.message, 'success');
                        if (response.association.status == 1) {
                            $($object).children().removeClass('bg-red').html(
                                '<i class="fa fa-ban"></i>');
                            $($object).children().addClass('bg-blue').html(
                                '<i class="fa fa-check"></i>');
                            $($object).attr('title', 'Deactivate');
                        } else {
                            $($object).children().removeClass('bg-blue').html(
                                '<i class="fa fa-check"></i>');
                            $($object).children().addClass('bg-red').html(
                                '<i class="fa fa-ban"></i>');
                            $($object).attr('title', 'Activate');
                        }
                    },
                    error: function (e) {
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });
        });
    </script>
@endsection
@section('dynamicdata')

    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
            </div>
        </div>
        <div class="box-body">

            @include('layouts.backend.alert')
            <div class="justify-content-end list-group list-group-horizontal ">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon">&nbsp;
                    Add
                </button>
                @include('Backend.Association.add')
            </div>
            <br>
            <div class="blank-page">
                <table class="table role-table" id="attTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">
                    @foreach($associations as $association)
                        <tr class="gradeX" id="row_{{ $association->id }}">

                            <th scope="row">{{$loop->iteration}}</th>
                            <td>
                                <div class="gallery-img">
                                    <a target="_blank" href="{{$association['image']}}"
                                       class="swipebox" title="Image Title">
                                        <img class="img-responsive"
                                             src="{{$association['image']}}" alt="">
                                        <span class="zoom-icon"> </span> </a>
                                </div>
                            </td>
                            <td>
                                {{$association['name'] ? $association['name'] : 'N/A'}}
                            </td>
                            <td>
                                {{$association['association_type'] == 1 ? 'Life Insurance ' : 'Non Life Insurance'}}
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#editModal{{$association['id']}}"
                                        class="btn btn-primary btn-flat">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a class="ml-3 delete-item" href="javascript:;" id="{{ $association->id }}" title="Delete Association">
                                    <button type="button"
                                            class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                <a href="javascript:;" class="change-status ml-3" title="{{ $association->status == 0 ? "Click to activate Association." : "Click to De-active Association." }}" id="{{ $association->id }}">
                                    @if($association->status == 1)
                                    <button type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    @else
                                        <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    @endif
                                </a>
                            </td>
                            <div class="modal fade" id="editModal{{$association['id']}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true" style="display: none;">
                                @include('Backend.Association.edit')
                            </div>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
