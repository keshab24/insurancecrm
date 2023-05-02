@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Permission Roles</p>
@endsection
@section('footer_js')
    <script>
        $(() => {
            $.get('{{route('permission_roles.getdatajson')}}', data => {
                $.each(data, function (k, val) {
                    $("input[name='role_permission[" + val.role_id + "_" + val.permission_id + "]'").attr('checked', true);
                });
            }, 'json');
        });
    </script>
@endsection

@section('dynamicdata')

    <!-- Form row -->
    <div class="box">

        <div class="box-body">
            <div class="dataTables_wrapper dt-bootstrap4">
                <div class="box-header">
                    <h3 class="box-title">Assign Permissions</h3>
                </div>

                <div class="box-body">

                    @include('layouts.backend.alert')
                    <form role="form" action="{{ route('admin.privilege.permission_roles.store') }}" method="post">
                        <div class="card-body">
                        @foreach($roles as $role)
                            <!-- checkbox -->
                                <div class="form-group">
                                    <label for="role_id">{{$role->display_name}}</label>
                                    @foreach($permissions as $permission)
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input"
                                                   id="role_permission[{{$role->id."_".$permission->id}}]"
                                                   type="checkbox"
                                                   name="role_permission[{{$role->id."_".$permission->id}}]">
                                            <label for="role_permission[{{$role->id."_".$permission->id}}]"
                                                   class="custom-control-label">{{$permission->display_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="id" id="id"/>
                            @endforeach
                            @csrf

                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                            class="mdi mdi-send mr-1"></i>Save
                                    </button>
                                    <a href="{{ route('admin.privilege.permission.index') }}"
                                       class="btn btn-danger waves-effect m-l-5"><i
                                            class="mdi mdi-close mr-1"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
