@extends('layouts.backend.container')
@section('title')
    <p class="h4 align-center mb-0">Dashboard</p>
@endsection
@section('dynamicdata')
    <div class="row mt-2">
        <!-- leads -->
        <div class="col-lg-6 col-sm-12">
            <div class="info-box">
            <span class="info-box-icon bg-org user-img">
                <img style="max-width: 100%" src="/uploads/{{Auth::User()->image_icon ? Auth::User()->image_icon : 'avatar.png'}}">
            </span>
                <div class="info-box-content mr-1">
                    <span class="info-box-text">{{__("Welcome To Dashboard")}}</span>
                    <h3>Hello, {{Auth::User()->username}}</h3>
                    <p style="margin-top: 30px;">
                        <a href="{{ route('user.kyc.entry') }}">KYC<i class="fa fa-long-arrow-right"></i></a>
                        @if (Auth::User()->kyc && Auth::User()->kyc->is_verified == 1)
                            <span class="badge badge-pill badge-success p-2">Verified</span>
                        @else
                            <span class="badge badge-pill badge-danger p-2">Not Verified</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <!-- leads -->

    @if(control('create-leads'))
        <!-- leads -->
            <div class="col-lg-6 col-sm-12">
                <div class="info-box">
            <span class="info-box-icon bg-org">
                    <i class="fa fa-users"></i>
            </span>
                    <div class="info-box-content mr-1">
                        
                        <span class="info-box-text">Total  Leads</span>
                        <h3>{{ $countLeads }}</h3>
                        
                        <p style="margin-top: 30px;">
                            <a href="{{ route('admin.leads.index') }}">Quick Link<i class="fa fa-long-arrow-right"></i></a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- leads -->
        @endif
    </div>
@endsection
