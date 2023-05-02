@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Core Values Contents</p>
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
                            Click here to change Top side Contents   <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </h5>
                    </div>

                    <div id="collapseWhyDiff" class="collapse" aria-labelledby="WhyDiff" data-parent="#accordion">
                        <div class="card-body">
                            <form class="p-2" method="POST" action="{{route('values.update',1)}}"
                                  enctype="multipart/form-data">
                                {{method_field('patch')}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="title">Left Title</label>
                                    <input type="text" name="values_title"
                                           value="{{$aboutContent['values_title'] ? $aboutContent['values_title'] : ''}}"
                                           class="form-control" placeholder="Enter core values title">
                                </div>
                                <div class="form-group">
                                    <label for="why_us_content">Left Description</label>
                                    <textarea name="values_content" class="form-control" id="ckeditor" cols="5"
                                              rows="10">{{$aboutContent['values_content'] ? $aboutContent['values_content'] : ''}}</textarea>
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
            @if(count($about)< 3)
                <div class="justify-content-end list-group list-group-horizontal ">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#addModal">
                        Add
                    </button>
                    @include('backend.Values.add')
                </div>
            @endif
            <br>
            <div class="blank-page">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($about as $why)
                        <tr>

                            <th scope="row">{{$loop->iteration}}</th>
                            
                            <td>
                                {{$why['title']}}
                            </td>
                            <td>{{$why['description']}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#editModal{{$why['id']}}">
                                    <i class="fa fa-pencil text-primary fa-2x"></i>
                                </button>&ensp;&ensp;
                                <form action="{{ route('values.destroy', $why['id']) }}"
                                      method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are you sure you want to delete?')"><i
                                            class="fa fa-trash text-danger fa-2x"></i></button>
                                </form>
                            </td>
                            <div class="modal fade" id="editModal{{$why['id']}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel"
                                 aria-hidden="true" style="display: none;">
                                @include('Backend.Values.edit')
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
