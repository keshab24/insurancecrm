@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">{{$title ? $title : 'Permission'}}</p>
@endsection
@section('dynamicdata')

    <!-- Form row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form role="form" action="{{ route('admin.privilege.permission.update', $permission->id) }}" method="post" class="form-simple" enctype="multipart/form-data">
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="{{$permission->name}}" name="name" id="name"
                                   class="form-control">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" value="{{$permission->display_name}}" name="display_name"
                                   id="display_name"
                                   class="form-control">
                            @if ($errors->has('display_name'))
                                <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('display_name') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" value="{{$permission->description}}" name="description"
                                   id="description"
                                   class="form-control">
                            @if ($errors->has('description'))
                                <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                            @endif
                        </div>
                        <input type="hidden" name="id" id="id" value="{{$permission->id}}"/>
                        @csrf

                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-send mr-1"></i>Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
