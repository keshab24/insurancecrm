@extends('layouts.backend.containerform')

@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">EDIT ROLES</h3>
        </div>
        <div class="box-body">

            <form id="roleEditForm" action="{{ route('admin.privilege.role.update', $role->id) }}" method="post">
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{$role->name}}" name="name" id="name"
                               class="form-control">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="display_name">Display Name</label>
                        <input type="text" value="{{$role->display_name}}" name="display_name"
                               id="display_name" class="form-control">
                        @if ($errors->has('display_name'))
                            <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('display_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" value="{{$role->description}}" name="description"
                               id="description" class="form-control">
                        @if ($errors->has('description'))
                            <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="content">Status:</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ ($role->is_active == 1) ? 'selected="selected"' : '' }}>Active</option>
                                <option value="0" {{ ($role->is_active == 0) ? 'selected="selected"' : '' }}>Inactive</option>
                            </select>
                    </div>

                    <input type="hidden" name="id" id="id" value="{{$role->id}}"/>
                    @csrf

                    <div class="form-group mb-0">
                        <div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                    class="mdi mdi-send mr-1"></i>Submit
                            </button>
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
