@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Why Us Contents</p>
@endsection

@section('footer_js')
    <script type="text/javascript">
        var oTable = $('#whyTable').dataTable();
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
                    url: "{{ url('/why-us') }}" + "/" + id,
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
            <div id="accordion">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#collapseWhyDiff" aria-expanded="true"
                         aria-controls="collapseWhyDiff" id="WhyDiff">
                        <h5 class="mb-0 text-capitalize btn-link">
                            Click here to change the left side Contents   <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </h5>
                    </div>

                    <div id="collapseWhyDiff" class="collapse" aria-labelledby="WhyDiff" data-parent="#accordion">
                        <div class="card-body">
                            <form class="p-2" method="POST" action="{{route('why-us.update',1)}}"
                                  enctype="multipart/form-data">
                                {{method_field('patch')}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="title">Left Title</label>
                                    <input type="text" name="why_us_title"
                                           value="{{$whyContent['why_us_title'] ? $whyContent['why_us_title'] : ''}}"
                                           class="form-control" placeholder="Enter why us title">
                                </div>
                                <div class="form-group">
                                    <label for="why_us_content">Left Description</label>
                                    <textarea name="why_us_content" class="form-control" id="ckeditor" cols="5"
                                              rows="10">{{$whyContent['why_us_content'] ? $whyContent['why_us_content'] : ''}}</textarea>
                                </div>
                                <div style="clear: both">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @if(count($why)< 4)
                <div class="justify-content-end list-group list-group-horizontal ">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#addModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon">&nbsp;
                        Add
                    </button>
                    @include('backend.WhyUs.add')
                </div>
            @endif
            <br>
            <div class="blank-page">
                <table class="table" id="whyTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">
                    @foreach($why as $why)
                        <tr id="row_{{ $why->id }}">

                            <th scope="row">{{$loop->iteration}}</th>
                            <td>
                                <div class="col-md">
                                    <div class="gallery-img">
                                        <a target="_blank" href="{{$why['image']}}"
                                           class="swipebox" title="Image Title">
                                            <img class="img-responsive"
                                                 src="{{$why['image']}}" alt="">
                                            <span class="zoom-icon"> </span> </a>

                                    </div>
                                </div>
                            </td>
                            <td>
                                {{$why['title']}}
                            </td>
                            <td>{{$why['description']}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#editModal{{$why['id']}}"
                                        class="btn btn-primary btn-flat">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a class="ml-3 delete-item" href="javascript:;" id="{{ $why->id }}"
                                   title="Delete item">
                                    <button type="button"
                                            class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                            </td>
                            <div class="modal fade" id="editModal{{$why['id']}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true" style="display: none;">
                                @include('Backend.WhyUs.edit')
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
