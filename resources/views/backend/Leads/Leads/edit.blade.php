<!-- Modal form to add a leads -->
@extends('layouts.backend.containerform')
@section('dynamicdata')
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit LeadSource</h3>
            </div>
<!-- standalone ckeditor image upload -->


    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.leads.update',['lead'=>$lead->id]) }}" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    
                    <h3>Customer Details</h3>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="lead_id" hidden>Lead ID:</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" name="lead_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="sales_person_name">Sales Person Name:</label>
                        <div class="col-sm-9">
                        <input type="text" value="{{$lead->sales_person_name}}" class="form-control" name="sales_person_name" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="customer_name">Customer Full Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{$lead->customer_name}}" name="customer_name" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="leadsource_id">Lead Source:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="leadsource_id">
                                <option value="0" disabled selected>Select Lead Source</option>
                                @foreach($lead_sources as $lead_source)
                                <option value="{{ $lead_source->id }}" @if($lead_source->id) selected @endif>{{ $lead_source->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="control-label col-sm-3" for="lead_source">Lead Type:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="leadsource_id">
                                <option value="0" disabled selected>Select Lead Type</option>
                                @foreach($lead_types as $lead_type)
                                <option value="{{ $lead_type->id }}" @if($lead_type->id) selected @endif>{{ $lead_type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Provinces</label>
                            <div class="form-s2">
                                <div>
                                    <select class="form-control formselect required" name="province_id" placeholder="Select Provinces" id="province">
                                        <option value="0" disabled selected>Select Province</option>
                                        @foreach($provinces as $categories)
                                        <option value="{{ $categories->id }}" @if($categories->id) selected @endif>
                                            {{ ucfirst($categories->province_name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>City</label>
                            <select class="form-control formselect required" name="city_id " placeholder="Select City" id="city">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="street_ward">street or ward no:</label>
                        <div class="col-sm-9">
                        <input type="text" value="{{$lead->street_ward}}" class="form-control" name="street_ward" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="phone">Phone Number:</label>
                        <div class="col-sm-9">
                        <input type="number" value="{{$lead->phone}}" class="form-control" name="phone" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Email:</label>
                        <div class="col-sm-9">
                        <input type="email" value="{{$lead->email}}" class="form-control" name="email" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="dob">Date of Birth:</label>
                        <div class="col-sm-9">
                        <input type="date" value="{{$lead->dob}}" class="form-control" name="dob" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="profession">Profession:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{$lead->profession}}" name="profession" autofocus>
                        </div>
                    </div>
                    <h3>Insurance Details</h3>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="insurence_company_name">Insurance Provider/Company:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="insurence_company_name" value="{{$lead->insurence_company_name}}" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="policy_cat">Policy Category:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="policy_cat">
                                <option value="0" disabled selected>Select Policy Category</option>
                                @foreach($policy_categories as $policy_categorie)
                                <option value="{{ $policy_categorie->id }}" @if($policy_categorie->id) selected @endif>{{ $policy_categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="policy_sub_cat">Policy Sub Category:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="policy_sub_cat">
                                <option value="0" disabled selected>Select Policy Sub Category</option>
                                @foreach($policy_sub_categories as $policy_sub_categorie)
                                <option value="{{ $policy_sub_categorie->id }}" @if($policy_sub_categorie->id) selected @endif>{{ $policy_sub_categorie->subcat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="policy_type">Policy Type:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="policy_type">
                                <option value="0" disabled selected>Select Policy Type</option>
                                @foreach($policy_types as $policy_types)
                                <option value="{{ $policy_types->id }}" @if($policy_types->id) selected @endif>{{ $policy_types->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="sun_insured">Est Sum Insured:</label>
                        <div class="col-sm-9">
                        <input type="number" class="form-control" value="{{$lead->sun_insured}}" name="sun_insured" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="maturity_period">Maturity Period:</label>
                        <div class="col-sm-9">
                        <input type="number" class="form-control" value="{{$lead->maturity_period}}" name="maturity_period" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="premium">Premium:</label>
                        <div class="col-sm-9">
                        <input type="number" value="{{$lead->premium}}" class="form-control" name="premium" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="lead_transfer_req">Lead Transfer Request:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="lead_transfer_req" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="content">Status:</label>
                        <div class="col-sm-9">
                            <select name="is_active" class="form-control">
                                <option value="1" @if($lead->is_active == 1) selected @endif>Active</option>
                                <option value="0" @if($lead->is_active == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="policy_doc">Policy Document</label>

                            <input type="file" name="policy_doc" id="policy_doc">
                            <p class="pr">Note: Attachment file format should be doc or pdf.</p>

                        </div>
                        <div class="col-md-6">
                            <label for="identity_doc">Identity Document</label>

                            <input type="file" name="identity_doc" id="identity_doc">

                            <p class="pr">Note: Attachment file format should be doc or pdf.</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success add">
                            <span id="" class='glyphicon'></span> Save
                        </button>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection