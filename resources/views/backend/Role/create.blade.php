@extends('layouts.backend.containerform')

@section('footer_js')

@endsection @section('dynamicdata')

<!-- iCheck -->
<div class="box box-success">
  <div class="box-header">
    <h3 class="box-title">ADD ROLES</h3>
  </div>
  <div class="box-body">

    <form id="roleAddForm" action="{{ route('admin.privilege.role.store') }}" method="post">
      @include('layouts.backend.alert')

        <div class="card-body">
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="Enter role name here">
                @if ($errors->has('name'))
                    <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="display_name">Display Name</label>
                <input type="text" name="display_name" id="display_name" value="{{old('display_name')}}" class="form-control" placeholder="Enter display name here">
                @if ($errors->has('display_name'))
                    <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('display_name') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="{{old('description')}}" class="form-control" placeholder="Enter short description here">
                @if ($errors->has('description'))
                    <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                @endif
            </div>
            <input type="hidden" name="id" id="id"/>
            @csrf

            <div class="form-group mb-0">
                <div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-send mr-1"></i>Submit</button>
                </div>
            </div>
        </div>
<!-- #END# Basic Table -->
</form>

<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col (right) -->
</div>
<!-- /.row -->
@stop
