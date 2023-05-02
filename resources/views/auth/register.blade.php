@extends('layouts.app')

@section('title')
    <title>Register | {{ env('APP_NAME') }}</title>
@endsection
<style>
    .admin--login--wrapper {
        height: 140vh !important;
        display: flex;
        align-items: normal !important;
    }

    .userTp {
        padding: 8px 30px !important;
    }

    .userTp:hover {
        color: #ffff !important;
    }

    button.close.fade-in {
        display: none;
    }
</style>
@section('content')
    <section class="card form--wrapper register-form">
        <a class="text-center" href="/">
            <img class="card-img-top text-center" src="{{ asset('frontend/img/logo.png') }}" alt="">
        </a>
        <div class="col-sm">
            @include('layouts.backend.alert')
            <form role="form" id="userAddForm" action="{{ route('user.register') }}" method="post">
                @csrf
                <div class="text-center">
                    <a id="imClient" class="btn btn-primary userTp">Im Client</a>
                    <a id="imAgent" class="btn btn-primary userTp active">Im Agent</a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="phone_number">Phone Number*</label>
                            <input type="tel" name="phone_number" class="form-control" required value="{{old('phone_number')}}"
                                   placeholder="Enter phone number"  pattern="[0-9]{1}[0-9]{9}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="username"> Agent Name *</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" min="4" required
                                   placeholder="Enter your name"/>
                        </div>
{{--                        <span id="nameHelp" class="d-none">--}}
{{--                        <br>--}}
{{--                        <small class="text-danger">Cannot add space in username !</small>--}}
{{--                        </span>--}}
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="password">Password *</label>
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" id="pasword" name="password" placeholder="Enter Password" required>
                                <div class="input-group-addon">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="email">Email *</label>
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="Enter email" required/>
                        </div>
                    </div>
                    <div class="agentAdd">
                        <hr>
                        <input class="" type="hidden" name="role_id" value="5">
                        <table class="table table-bordered" id="dynamicTable">
                            <tr>
                                <th>Category*</th>
                                <th>Liscence Number*</th>
                                <th class="d-none">Action</th>
                            </tr>
                            <tr>
                                <td><select class="form-control m-bot15" name="company_id[]" required>
                                        <option value="" selected>Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="liscence_number[]" min="0"
                                           placeholder="Enter liscence number" class="form-control"/></td>
                                <td>
                                    <button type="button" onClick="addComp()" name="add" id="addCompany"
                                            class="btn btn-success d-none">Add More
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div>

                    <div class="modal-footer remarks-modal-footer pt-2 pb-0 px-0">

                        <button type="submit" class="btn btn-primary c-btn-style add c-primary-btn">
                            Register
                        </button>
                    </div>

                </div>
            </form>

            <p class="text-md text-center">
                Already have an account <a href="/admin" class="strong-600 text-decoration-none">Log In</a>
            </p>
            <div class="back--home border-0">
                <a href="/">Back to home</a>
            </div>
        </div>
    </section>
    <!-- </div> -->
@endsection
@section('script')
    @if (session('success_message'))
        <script>
            $('#userAddForm').addClass('d-none');
        </script>
    @endif
    <script type="text/javascript">
        $('#imClient').on('click', function () {
            $('.agentAdd').html(null);
            $('#imAgent').removeClass('active');
            $('#imClient').addClass('active');
        });
        $('#imAgent').on('click', function () {
            $('#imClient').removeClass('active');
            $('#imAgent').addClass('active');
            $('.agentAdd').html(null);
            $('.agentAdd').append('<hr>\n' +
                '                    <input class="" type="hidden" name="role_id" value="5">\n' +
                '                <table class="table table-bordered" id="dynamicTable">\n' +
                '                    <tr>\n' +
                '                        <th>Category*</th>\n' +
                '                        <th>Liscence Number*</th>\n' +
                '                        <th>Action</th>\n' +
                '                    </tr>\n' +
                '                    <tr>\n' +
                '                        <td><select class="form-control m-bot15" name="company_id[]" required>\n' +
                '                                <option value="" selected>Select Company</option>\n' +
                '                                @foreach($companies as $company)\n' +
                '                                    <option value="{{$company->id}}">{{$company->name}}</option>\n' +
                '                                @endforeach\n' +
                '                            </select>\n' +
                '                        </td>\n' +
                '                        <td><input type="text" name="liscence_number[]" min="0" placeholder="Enter Company liscence number" class="form-control" /></td>\n' +
                '                        <td><button type="button" onClick="addComp()" name="add" id="addCompany" class="btn btn-success">Add More</button></td>\n' +
                '                    </tr>\n' +
                '                </table> <br>');
        });

        var i = 0;

        $(document).on('click', '#addCompany', function () {
            // alert('button clicked');
            ++i;

            $("#dynamicTable").append('<tr><td><select class="form-control m-bot15" name="company_id[]"><option value="" selected>Select Company</option>@foreach($companies as $company) <option value="{{$company->id}}">{{$company->name}}</option>@endforeach </select></td> <td><input type="text" name="liscence_number[]" min="0" placeholder="Enter liscence number" class="form-control" /></td> <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });

        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });
        $('.user-name').on('keypress', function (e) {
            $('#nameHelp').addClass('d-none');
            if (e.which == 32) {
                $('#nameHelp').removeClass('d-none');
                return false;
            }
        });
    </script>
@endsection
