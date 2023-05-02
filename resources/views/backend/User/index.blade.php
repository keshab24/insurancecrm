@extends('layouts.backend.containerlist')

@section('footer_js')
    <!-- formValidation -->
    <script src="{{ asset('backend/js/formValidation/formValidation.min.js') }}"></script>
    <script src="{{ asset('backend/js/formValidation/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var oTable = $('#user-table').dataTable();
            var roles = (localStorage.getItem("roles") !== null) ? JSON.parse(localStorage.getItem('roles')) : [];

            $('#userAddForm').formValidation({
                framework: 'bootstrap',
                excluded: ':disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    // full_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Full Name field is required.'
                    //         }
                    //     }
                    // },
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Username field is required.'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password field is required.'
                            },
                            stringLength: {
                                min: 6,
                                message: 'Password must be more than 6 characters long.'
                            },
                        }
                    },
                    role_id: {
                        validators: {
                            notEmpty: {
                                message: 'Role field is required.'
                            }
                        }
                    },
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();
                var $form = $(e.target),
                    fv = $form.data('formValidation');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: $form.attr('action'),
                    data: $form.serialize(),

                    success: function (response) {
                        swal('success', response.message, 'success');

                        /*      $('#userAddForm')[0].reset();
                              var htmlToAppend = '<tr class="gradeX" id="row_' + response.user.id +
                                  '">';
                              // htmlToAppend += '<td>' + response.user.full_name + '</td>';
                              htmlToAppend += '<td>' + response.user.username + '</td>';

                              if (response.user.role_id in roles)
                                  htmlToAppend += '<td class="role">' + roles[response.user.role_id] +
                                  '</td>';
                              else
                                  htmlToAppend += '<td class="role">' + response.user.role_id +
                                  '</td>';
          /*
                              htmlToAppend += '<td>' +
                                  '<a class="edit-user" href="javascript:;" id="' + response.user.id +
                                  '" title="Edit User"><button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float" ><i class="fa fa-pencil"></i></button></a> &nbsp;' +
                                  '<a class="delete-user" href="javascript:;" id="' + response.user.id +
                                  '" title="Delete User"><button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float" ><i class="fa fa-trash"></i></button></a> &nbsp;';*/
                        /*     if (response.user.is_active == '1') {
                                 htmlToAppend +=
                                     '<a href="javascript:;" class="change-status" title="Deactivate" id="' +
                                     response.user.id +
                                     '"><button type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float" ><i class="fa fa-check"></i></button></a> &nbsp;';
                             } else {
                                 htmlToAppend +=
                                     '<a href="javascript:;" class="change-status" title="Activate" id="' +
                                     response.user.id +
                                     '"><button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float" ><i class="fa fa-ban"></i></button></a> &nbsp;';
                             }

                             htmlToAppend += '</td>' +
                                 '</tr>';
                             $('#tablebody').append(htmlToAppend);*/
                        $('#addNewUserModal').modal('hide');
                        location.reload();
                    },
                    error: function (e) {
                        showErrorMessageInSweatAlert(e);
                    },
                });
            });

            $('#tablebody').on('click', '.delete-user', function (e) {
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
                        url: "{{ url('/admin/privilege/user/') }}" + "/" + id,
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

            $('#tablebody').on('click', '.edit-user', function (e) {
                e.preventDefault();
                $object = $(this);
                var id = $object.attr('id');
                // console.log(id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('/admin/privilege/user/') }}" + "/" + id,
                    dataType: 'json',
                    success: function (response) {
                        // console.log(response);
                        // debugger;
                        $('#editUserModal').modal().show();
                        $('#userEditForm').attr('action', "{{ url('/admin/privilege/user/') }}" + "/" + response.user.id,);
                        $(".user_id").val(response.user.id);
                        $(".email").val(response.user.email);
                        $(".phone_number").val(response.user.phone_number);
                        $(".designation").val(response.user.designation);
                        $(".username").val(response.user.username);
                        $(".employee_id").val(response.user.employee_id);
                        $(".role_id").val(response.user.role_id);
                        $(".is_active").val(response.user.is_active);
                    },
                    error: function (e) {
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });

            $('#userEditForm').formValidation({
                framework: 'bootstrap',
                excluded: ':disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email field is required.'
                            }
                        }
                    },
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Username field is required.'
                            }
                        }
                    },
                    role_id: {
                        validators: {
                            notEmpty: {
                                message: 'Role field is required.'
                            }
                        }
                    },
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();
                var $form = $(e.target),
                    fv = $form.data('formValidation');

                $.ajax({
                    type: "PUT",
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        swal('Success', response.message, 'success');
                        $('#userEditForm')[0].reset();
                        $('#tablebody').find('#row_' + response.user.id).find('.email').text(
                            response.user.email);
                        $('#tablebody').find('#row_' + response.user.id).find('.username').text(
                            response.user.username);
                        $('#tablebody').find('#row_' + response.user.id).find('.employee_id').text(
                            response.user.employee_id);
                        $('#tablebody').find('#row_' + response.user.id).find('.role').text(
                            roles[response.user.role_id]);
                        $('#editUserModal').modal('hide');
                    },
                    error: function (e) {
                        showErrorMessageInSweatAlert(e);
                    },
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
                        url: "{{ url('/admin/privilege/user/change/status/') }}" + "/" + id,
                        data: {
                            'id': id,
                            _method: 'put'
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal('Success', response.message, 'success');
                            if (response.user.is_active == 1) {
                                $($object).children().removeClass('bg-red').html(
                                    '<i class="fa fa-ban"></i> Not Active');
                                $($object).children().addClass('bg-blue').html(
                                    '<i class="fa fa-check"></i> Active');
                                $($object).attr('title', 'Deactivate');
                            } else {
                                $($object).children().removeClass('bg-blue').html(
                                    '<i class="fa fa-check"></i> Active');
                                $($object).children().addClass('bg-red').html(
                                    '<i class="fa fa-ban"></i> Not Active');
                                $($object).attr('title', 'Activate');
                            }
                        },
                        error: function (e) {
                            swal('Oops...', 'Something went wrong!', 'error');
                        }
                    });
                });
            });

            $('#addNewUserModal').on('hidden.bs.modal', function () {
                $('#userAddForm').formValidation('resetForm', true);
            });
            $('#editUserModal').on('hidden.bs.modal', function () {
                $('#userEditForm').formValidation('resetForm', true);
            });

        });
    </script>
@endsection
@section('title')
    <p class="h4 align-center mb-0">Users</p>
@endsection

@section('dynamicdata')


    <div class="box">
        <div class="text-right mr-3">
            <a class="btn btn-primary btn-sm" href="{{route('admin.privilege.user.excel')}}"><i class="fa fa-download mr-1" aria-hidden="true"></i> Download Excel</a>
        </div>
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
                <button class="btn btn-primary btn-sm c-primary-btn add-modal shadow-none mx-2" data-toggle="modal"
                        data-target="#addNewUserModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> &nbsp; Add New User &nbsp;
                </button>
            </div>
        </div>

        <div class="box-body">
            <table id="user-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    {{-- <th>Name</th> --}}
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                    <th class="dt-center">Actions</th>
                </tr>
                </thead>
                <tbody id="tablebody">
                @foreach($users as $index=>$user)
                    <tr class="gradeX" id="row_{{ $user->id }}">
                        {{-- <td class="full_name">
                            {{ $user->full_name }}
                        </td> --}}
                        <td class="username">
                            {{ $user->username }}
                        </td>
                        <td>
                            {{ $user->phone_number }}
                        </td>
                        <td class="role">
                            @if($user->role) {{ $user->role->display_name }} @endif
                        </td>
                        <td class="role">
                            {{ $user->created_at }}
                        </td>
                        <td>
                            @if($user->is_active == 1)
                                <a href="javascript:;" class="change-status" title="Deactivate" id="{{ $user->id }}">
                                    <button type="button"
                                            class="btn btn-sm bg-blue btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-check"></i> Active
                                    </button>
                                </a>
                            @else
                                <a href="javascript:;" class="change-status" title="Activate" id="{{ $user->id }}">
                                    <button type="button"
                                            class="btn btn-sm bg-red btn-circle waves-effect waves-circle waves-float">
                                        <i class="fa fa-ban"></i> Not Active
                                    </button>
                                </a>
                            @endif
                        </td>

                        <td class="justify-content-center">
                            <a class="edit-user" href="javascript:;" id="{{ $user->id }}" title="Edit User">
                                <button type="button" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </a>&nbsp;
                            <a class="login-user mr-2" href="{{ route('admin.privilege.login.as.user',[$user->id]) }}" id="{{ $user->id }}" title="Login as this User">
                                <button type="button"
                                        class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="fa fa-user"></i>
                                </button>
                            </a>

                            <a class="delete-user" href="javascript:;" id="{{ $user->id }}" title="Delete User">
                                <button type="button"
                                        class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </a>&nbsp;
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- Modal Start -->
    <div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal--header d-flex">
                    <h4 class="modal-title">New User</h4>
                </div>
                <form role="form" id="userAddForm" action="{{ route('admin.privilege.user.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        {{-- <div class="form-group">
                            <div class="form-line">
                                <label for="username">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Enter full name" />
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="form-line">
                                <label for="designation">Designation *</label>
                                <input type="text" name="designation" class="form-control" id="designation"
                                       placeholder="Enter Designation"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="username">Username *</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="phone_number">Phone number *</label>
                                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="password">Password *</label>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Enter password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="email">Email *</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Enter email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Select Role</label>
                            <select class="form-control m-bot15" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control m-bot15" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="modal-footer remarks-modal-footer pt-2 pb-0 px-0">
                            <button type="button" class="btn btn-outline-secondary c-btn-style c-ghost-btn"
                                    data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary c-btn-style add c-primary-btn">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <!-- Modal Start -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         data-keyboard="false"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" id="userEditForm" action="{{ route('admin.privilege.user.update', $user->id) }}"
                      method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="email">Email *</label>
                                <input type="text" name="email" class="form-control email"
                                       placeholder="Enter full name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="username">Designation *</label>
                                <input type="text" name="designation" class="form-control designation"
                                       placeholder="Enter Designation"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="username">Username *</label>
                                <input type="text" name="username" class="form-control username" id="username"
                                       placeholder="Enter username"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="username">Phone Number *</label>
                                <input type="text" name="phone_number" class="form-control phone_number" id="phone_number"
                                       placeholder="Enter phone number"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="password">Password *</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" id="pasword" name="password"
                                           placeholder="Enter Password">
                                    <div class="input-group-addon">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Select Role *</label>
                            <select class="form-control m-bot15 role_id" name="role_id">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control m-bot15 is_active" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" class="form-control user_id"/>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
