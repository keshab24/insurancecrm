@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Teams</p>
@endsection
@section('footer_js')
    <script type="text/javascript">
        var oTable = $('#testimonialTable').dataTable();
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
                    url: "{{ url('/team') }}" + "/" + id,
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
                    url: "{{ url('team/status') }}" + "/" + id,
                    data: {
                        'id': id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        swal('Success', response.message, 'success');
                        if (response.testimonial.status == 1) {
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
                data-target="#addModal">
                Add Team
                </button>
                @include('Backend.Team.add')
            </div>
            <br>
            <div class="blank-page">
                <table class="table" id="testimonialTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">
                    @foreach($teams as $testimonial)
                        <tr>

                            <th scope="row">{{$loop->iteration}}</th>
                            <td>
                                <div class="col-md">
                                    <div class="gallery-img">
                                        <a target="_blank" href="{{$testimonial['image']}}"
                                           class="swipebox" title="{{$testimonial['name']}}">
                                            <img class="img-responsive"
                                                 src="{{$testimonial['image']}}" alt="">
                                            <span class="zoom-icon"> </span> </a>

                                    </div>
                                </div>
                            </td>
                            <td>
                                {{$testimonial['name']}}
                                <br>
                              
                            </td>
                            <td>{{$testimonial['designation']}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#editModal{{$testimonial['id']}}"
                                        class="btn btn-primary btn-flat">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a class="ml-3 delete-item" href="javascript:;" id="{{ $testimonial->id }}"
                                   title="Delete Testimonial">
                                    <button type="button"
                                            class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                <a href="javascript:;" class="change-status ml-3"
                                   title="{{ $testimonial->status == 0 ? "Click to activate Team." : "Click to De-active Team." }}"
                                   id="{{ $testimonial->id }}">
                                    @if($testimonial->status == 1)
                                        <button type="button"
                                                class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    @endif
                                </a>
                            </td>
                            <div class="modal fade" id="editModal{{$testimonial['id']}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true" style="display: none;">
                                @include('Backend.Team.edit')
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
@section('footer_js')
@endsection
