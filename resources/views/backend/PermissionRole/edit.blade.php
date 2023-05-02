@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Permission Roles Edit</p>
@endsection
@section('dynamicdata')
    <section class="content-header">
        <h1>
            Edit Permission_roles
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('admin.privilege.permission_roles.index') }}">permission_role</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <form role="form" action="{{ route('admin.privilege.permission_roles.update') }}" method="post">
                <div class="box-body">
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <label for="permission_id">Permission_id</label><input type="text"
                                                                               value="{{$permission_role->permission_id}}"
                                                                               name="permission_id" id="permission_id"
                                                                               class="form-control"></div>
                    <div class="form-group">
                        <label for="role_id">Role_id</label><input type="text" value="{{$permission_role->role_id}}"
                                                                   name="role_id" id="role_id" class="form-control">
                    </div>
                    <input type="hidden" name="id" id="id" value="{{$permission_role->id}}"/>
                    {{ csrf_field() }}
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.permission_roles') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
