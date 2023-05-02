@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Edit Profile</p>
@endsection

@section('dynamicdata')
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                @include('layouts.backend.alert')
                <div class="img-sec">
                <img class="user-img" src="{{asset('/images/images.png')}}">
                </div>
                @php($user = Auth::user())
                <form role="form" id="userEditForm" action="{{ route('user.profile.modify', $user->id) }}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="email">Email *</label>
                                <input type="text" name="email" class="form-control email"
                                       placeholder="Enter Email Address" value="{{$user->email}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <label for="username">Username *</label>
                                <input type="text" name="username" class="form-control username" value="{{$user->username}}" id="username"
                                       placeholder="Enter username" required/>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
@stop
