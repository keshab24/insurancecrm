<div class="modal left fade" id="addModal" tabindex="addLead" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal--header d-flex">
                <h4 class="modal-title">Add Lead</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                           aria-controls="home" aria-selected="true">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" aria-selected="false">Documents</a>
                    </li>
                </ul>
                <form class="form-horizontal form-add-leads" id="leadAddEdit" role="form" method="POST"
                      action="{{route('admin.leads.store')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="lead_id" id="lead_id" value="">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="container leads-tab-content">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="leads--file--upload col-md-12">
                                                <img src="{{ asset('uploads/upload-regular-20.svg') }}" alt="Add-icon">
                                                <p>Drag and Drop here </br> <strong>Or</strong></p>
                                                <!-- <input type="file" class="" id="" hiddden> -->
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn-upload">Browse Files</button>
                                                    <input type="file" name="policy_doc" id="policy_doc" />
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Customer Full Name</label>
                                                <input type="customer_name" class="form-control"
                                                    id="customer_name" placeholder="Full name here" name="customer_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Profession</label>
                                                    <select class="form-control" id="profession" name="profession" type="profession" required>
                                                        <option selected disabled>Select Profession</option>
                                                        <option>Private jobs</option>
                                                        <option>Public Service</option>
                                                        <option>Non Profit Organization</option>
                                                        <option>Student</option>
                                                        <option>Entrepreneur</option>
                                                        <option>Home maker</option>
                                                        <option>Small Business</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Lead Source</label>
                                                <select class="form-control" id="leadsource_id" name="leadsource_id">
                                                    <option selected disabled>Select</option>
                                                    @foreach($lead_sources as $leadsource)
                                                <option value="{{$leadsource->id}}">{{$leadsource->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Lead Type</label>
                                                <select class="form-control" id="leadtype_id" name="leadtype_id">
                                                    <option selected disabled>Select</option>
                                                    @foreach($lead_types as $leadtype)
                                                    <option value="{{$leadtype->id}}">{{$leadtype->type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 d-inline-flex p-0">
                                            <div class="col-6 no-gutter">
                                                <div class="form-group">
                                                    <label for="province">Province</label>
                                                    <select class="form-control" id="province" name="province">
                                                        <option selected disabled>Select</option>
                                                        @foreach($provinces as $province)
                                                    <option value="{{$province->id}}">{!!$province->province_name!!}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="CustomerFullName" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="city" name="street_ward" placeholder="City" name="city_id " >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="CustomerFullName" class="form-label">Street and Ward
                                                    Name</label>
                                                <input type="text" class="form-control" id="street_ward" name="street_ward">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                                <input type="number" class="form-control" id="phone" name="phone">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">E-mail</label>
                                                <input type="text" class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="insureedob" class="form-label">Date of Birth
                                                    (Insuree)</label>
                                                <input type="date" class="form-control" id="dob" name="dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Sales Person Name</label>
                                                <select class="form-control" id="sales_person_name" name="sales_person_name">
                                                    <option selected disabled>Select Sales Person Name</option>

                                                    @foreach($users as $user)
                                                    <option @if(Auth::user()->id == $user->id) selected @endif>{{$user->username}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- Container end -->

                                <div class="container leads-tab-content lower-form-contents">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="insurancecompany">Insurance Provider/Company</label>
                                                <select class="form-control" id="insurence" name="insurence_company_name">
                                                    <option selected disabled>Select</option>
                                                    <option value="1">Nepal Life Insurance Company</option>
                                                    <option value="2">Reliable Nepal Life Insurance Ltd.</option>
                                                    <option value="3">Sun Nepal Life Insurance Company Ltd.</option>
                                                    <option value="3">Mahalaxmi Life Insurance Ltd</option>
                                                    <option value="3">Premier Insurance Company (Nepal) Ltd.</option>
                                                    <option value="3">Metlife Alico</option>
                                                    <option value="3">United Insurance Company (Nepal) Ltd.</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Policy Category</label>
                                                <select class="form-control" id="policy_cat" name="policy_cat">
                                                    <option selected>Select</option>
                                                    <option value="1">Life</option>
                                                    <option value="2">Non-Life</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="insurancecompany">Policy Sub Category</label>
                                                <select class="form-control" id="policy_sub_cat" name="policy_sub_cat">
                                                    <option selected disabled>Select</option>
                                                    @foreach($policy_sub_categories as $policy_sub)
                                                    <option value="{{$policy_sub->id}}">{{$policy_sub->subcat_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Policy Type</label>
                                                <select class="form-control" id="policy_type" name="policy_type">
                                                    <option selected>Select</option>
                                                    <option value="1">Life</option>
                                                    <option value="2">Non-Life</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="estimated sum insure" class="form-label">Est Sum
                                                    Insured</label>
                                                <input type="number" class="form-control" id="sun" name="sun_insured">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="insurancecompany">Maturity Period</label>
                                                <select class="form-control" id="maturity" name="maturity_period">
                                                    <option selected disabled>Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="estimated sum insure" class="form-label">Premium</label>
                                                <input type="number" class="form-control" id="premium" name="premium">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="insurancecompany">Lead Transfer Request</label>
                                                <select class="form-control" id="transfer" name="lead_transfer_req">
                                                    <option selected disabled>Select</option>
                                                   @foreach($users as $user)
                                                    <option>{{$user->username}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="makeuser">Make Customer</label>
                                                <select class="form-control" id="is_user" name="is_user">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="container leads-tab-content">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Upload Document</label>
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                        name="identity_doc">
                                </div>
                                </div>
                            </div>

                            <div class="leadsform-action-btn d-inline-flex justify-content-between">
                                <div class="leadsform-action-btn-cancel btn-36 justify-content-start ml-4">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>

                                <div class="leadsform-action-btn-Submit btn-36 justify-content-end mr-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>
