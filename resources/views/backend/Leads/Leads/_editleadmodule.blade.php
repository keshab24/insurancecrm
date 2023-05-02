<form id="editform" class="form-horizontal" role="form" method="POST" action="{{ route('admin.leads.update','lead')}}"
      enctype="multipart/form-data">
    @csrf
    @method('PATCH')

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
                                <input type="file" name="policy_doc" id="policy_doc"/>
                            </div>

                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Customer Full Name</label>
                            <input type="customer_name" class="form-control"
                                   id="customer_name" placeholder="Full name here" name="customer_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Profession</label>
                            <input type="profession" name="profession" class="form-control"
                                   id="profession" placeholder="Profession here">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Lead Source</label>
                            <select class="form-control" id="leadsource_id" name="leadsource_id">
                                <option selected disabled>Select</option>
                                <option value="6">Inbound Call</option>
                                <option value="5">Outbound Call</option>
                                <option value="1">Website</option>
                                <option value="4">App</option>
                                <option value="2">Facebook</option>
                                <option value="3">Instagram</option>
                                <option value="7">Linkedin</option>
                                <option value="8">Direct Visit</option>
                                <option value="9">Reference</option>
                                <option value="10">Corporate</option>
                                <option value="11">VFS</option>
                                <option value="12">Others</option>
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
                                        <option value="{{$province->id}}"
                                                @if($province->id) selected @endif>{{$province->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="CustomerFullName" class="form-label">City</label>
                                <select class="form-control formselect required" name="city_id "
                                        placeholder="Select City" id="city">

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
                {{--  <div class="col-6">
                        <div class="form-group">
                            <label for="prosposerdob" class="form-label">Date of Birth
                                (Prosposer)</label>
                            <input type="date" class="form-control" id="prosposerdob">
                        </div>
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="leadsremarks">Note:</label>
                            <textarea class="form-control" id="note" name="note" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                {{--  <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="insureedob" class="form-label">Contact Person Name</label>
                            <input type="text" class="form-control" id="insureedob"
                                placeholder="Full Name">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group ">
                            <input type="number" class="form-control manual-margin" id="contact person name"
                                placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <input type="email" class="form-control manual-margin" id="contact person email"
                                placeholder="Email" required>
                        </div>
                    </div>
                </div>
    --}}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Sales Person Name</label>
                            <select class="form-control" id="sales_person_name" name="sales_person_name">
                                <option selected disabled>Select Sales Person Name</option>
                                <option>Rohit Chapagain</option>
                                <option>Bishes GC</option>
                                <option>Arika Karki</option>
                                <option>Dibya Tara Shakya</option>
                                <option>Manish Shrestha</option>
                                <option>Suresh Shahi</option>
                                <option>Bipin Maharjan</option>
                                <option>Swheta Khadgi</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Container end -->

            <div class="container leads-tab-content">
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
                                <option selected disabled>Select</option>
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
                                <option selected disabled>Select</option>
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
                                <option value="2">3</option>
                                <option value="2">4</option>
                                <option value="2">5</option>
                                <option value="2">6</option>
                                <option value="2">7</option>
                                <option value="2">8</option>
                                <option value="2">9</option>
                                <option value="2">10</option>
                                <option value="2">11</option>
                                <option value="2">12</option>
                                <option value="2">13</option>
                                <option value="2">14</option>
                                <option value="2">15</option>
                                <option value="2">16</option>
                                <option value="2">17</option>
                                <option value="2">18</option>
                                <option value="2">19</option>
                                <option value="2">20</option>
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
                                <option selected>Select</option>
                                <option value="1">Kamal Adhikari</option>
                                <option value="2">SIddhartha Gautam</option>
                                <option value="2">Bikram Oli</option>
                                <option value="2">Rakesh Dahal</option>
                                <option value="2">Girish Khatiwada</option>
                                <option value="2">Bizon Rana</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="makeuser">Make User</label>
                            <select class="form-control" id="is_user" name="is_user">
                                <option selected disabled>Select</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Second
            <div class="form-group">
                <label for="exampleFormControlFile1">Example file input</label>
                <input type="file" class="form-control-file" id="identity_doc" name="identity_doc">
            </div>
        </div>

        <div class="leadsform-action-btn d-inline-flex justify-content-between">
            <div class="leadsform-action-btn-cancel btn-36 justify-content-start ml-4">
                <button type="button" class="btn btn-outline-secondary">Cancel</button>
            </div>

            <div class="leadsform-action-btn-Submit btn-36 justify-content-end mr-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
</form>
