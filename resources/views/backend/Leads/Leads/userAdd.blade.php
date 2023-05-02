<div class="modal left fade" id="addNewUserModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     data-keyboard="false"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal--header d-flex">
                <h4 class="modal-title">Convert To Client</h4>
            </div>
            <form role="form" id="userAddForm"
                  action="{{ route('admin.privilege.user.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="username">Username *</label>
                            <input type="text" name="username" class="form-control"
                                   placeholder="Enter username"
                                   value="{{$lead->customer_name}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" id="pasword" name="password" value="{{Str::random(10)}}">
                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="email">Email *</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="Enter email" value="{{$lead->email}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" class="form-control" id="phone"
                                   placeholder="Enter phone" value="{{$lead->phone}}"/>
                        </div>
                    </div>
                    <input type="hidden" name="role_id" value="4">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control m-bot15" name="is_active">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="modal-footer remarks-modal-footer pt-2 pb-0 px-0">
                        <button type="button"
                                class="btn btn-outline-secondary c-btn-style c-ghost-btn"
                                data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit"
                                class="btn btn-primary c-btn-style add c-primary-btn">
                            Add User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
