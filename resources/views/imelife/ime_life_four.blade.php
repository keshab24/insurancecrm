@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">IME LIfe Insurance</p>
@endsection
@section('footer_js')
<script>
    $(document).ready(function () {
        $('.search-select').select2();
    });

</script>
@endsection
@section('dynamicdata')

<form class="form-inline" action="{{ route('admin.ime.life.insurance.four') }}" method="post">
    @csrf
    {{-- <div class="card m-3"> --}}

    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Personal</h5>

        <div class="card-body">


            <div class="form-group col-12">
                <div class="row justify-content-center col-12">

                    <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Name </b><span
                            style="color:red">*</span></label>

                    <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                        placeholder="Enter full name">


                </div>
            </div>

            <div class="form-group col-12">
                <div class="row  justify-content-center col-12">

                    <label for="Full name" class="pl-5  pr-5 col-3"><b>Gender </b><span
                            style="color:red">*</span></label>

                    <select name="gender" id="gen" class="form-control search-select  mr-sm-3 ml-3 col-8"
                        id="inlineFormInputName3">
                        <option value="male">male</option>
                        <option value="female">female</option>
                        <option value="other">other</option>
                    </select>


                </div>
            </div>


            <div class="form-group col-12">
                <div class="row justify-content-center col-12">

                    <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Email </b><span
                            style="color:red">*</span></label>

                    <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                        placeholder="Enter email">


                </div>
            </div>

            <div class="form-group col-12">
                <div class="row  justify-content-center col-12">

                    <label for="Full name" class="pl-5  pr-5 col-3"><b>Education Qualification </b><span
                            style="color:red">*</span></label>

                    <select name="edu" id="gen" class="form-control search-select  mr-sm-3 ml-3 col-8"
                        id="inlineFormInputName3">
                        <option value="uslc">Under Slc</option>
                        <option value="feunder Slc">Slc Passed</option>
                        <option value="plustwo">+2</option>
                        <option value="bachelor">Bachelor</option>
                        <option value="master">Master</option>
                    </select>


                </div>
            </div>







        </div>
    </div>


    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Address</h5>

        <div class="card-body">


            <div class="form-group col-12">
                <div class="row justify-content-center col-12">

                    <label for="Full name" class="col-3"><b>Permanent </b><span style="color:red">*</span></label>

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2"
                        placeholder="Enter Tole/street">

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2" placeholder="Enter city">

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2" placeholder="Enter ward">
                </div>
            </div>

            <div class="form-group col-12">
                <div class="row justify-content-center col-12">



                    <select name="gender" id="gen" class="form-control mr-sm-3 col-2 mr-3" id="inlineFormInputName3">
                        <option value=""></option>
                        <option value="fe">fe</option>
                        <option value="other">other</option>
                    </select>

                    <select name="gender" id="gen" class="form-control mr-sm-3 ml-5 col-2" id="inlineFormInputName3">
                        <option value=""></option>
                        <option value="fe">fe</option>
                        <option value="other">other</option>
                    </select>

                </div>
            </div>

            <div class="form-group col-12">
                <div class="row justify-content-center col-12">
                    <div class="form-check col-12">
                        <input id="checkbox2" type="checkbox" name="pwb" value="yes">
                        <label for="checkbox2">Chek here if current address is same as permanent</label>
                    </div>
                </div>
            </div>

            <div class="form-group col-12">
                <div class="row justify-content-center col-12">

                    <label for="Full name" class="col-3"><b>Present </b><span style="color:red">*</span></label>

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2"
                        placeholder="Enter Tole/street">

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2" placeholder="Enter city">

                    <input type="text" class="form-control mr-sm-3" id="inlineFormInputName2" placeholder="Enter ward">
                </div>
            </div>

            <div class="form-group col-12">
                <div class="row justify-content-center col-12">



                    <select name="gender" id="gen" class="form-control mr-sm-3 col-2 mr-3" id="inlineFormInputName3">
                        <option value=""></option>
                        <option value="fe">fe</option>
                        <option value="other">other</option>
                    </select>

                    <select name="gender" id="gen" class="form-control mr-sm-3 ml-5 col-2" id="inlineFormInputName3">
                        <option value=""></option>
                        <option value="fe">fe</option>
                        <option value="other">other</option>
                    </select>

                </div>
            </div>
        </div>
    </div>


            <div class="card w-100 Card--custom__header">
                <h5 class="card-header">Identification</h5>

                <div class="card-body">


                    <div class="form-group col-12">
                        <div class="row justify-content-center col-12">

                            <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Proof Of Age based on </b><span
                                    style="color:red">*</span></label>

                                    <select name="gender" id="gen" class="form-control search-select  mr-sm-3 ml-3 col-8"
                                    id="inlineFormInputName3">
                                    <option value="male">Passport</option>
                                    <option value="female">Citizenship</option>
                                    <option value="female">License</option>
                                    <option value="other">other</option>
                                </select>


                        </div>
                    </div>

                    <div class="form-group col-12">
                        <div class="row  justify-content-center col-12">

                            <label for="Full name" class="pl-5  pr-5 col-3"><b>Id #/Citizenship # </b><span
                                    style="color:red">*</span></label>

                                    <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                                    placeholder="Enter Id number">
    
                        </div>
                    </div>
                </div>
            </div>



            <div class="card w-100 Card--custom__header">
                <h5 class="card-header">Nominee Detail(optional)</h5>

                <div class="card-body">


                        <div class="form-group col-12">
                                <div class="row  justify-content-center col-12">
        
                                    <label for="Full name" class="pl-5  pr-5 col-3"><b>Nominee Name </b><span
                                            style="color:red">*</span></label>
        
                                            <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                                            placeholder="Enter full name">
            
                                </div>
                            </div>

                    <div class="form-group col-12">
                        <div class="row justify-content-center col-12">

                            <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Relationship with nominee </b><span
                                    style="color:red">*</span></label>

                                    <select name="rel" id="rel" class="form-control search-select  mr-sm-3 ml-3 col-8"
                                    id="inlineFormInputName3">
                                    <option value="male">Father/son</option>
                                    <option value="female">Brother/sister</option>
                                    <option value="female">husband/wife</option>
                                    <option value="other">other</option>
                                </select>


                        </div>
                    </div>
                </div>
            </div>
              
            <div class="card w-100 Card--custom__header">
                    <h5 class="card-header">Personal Health Statement</h5>
    
                    <div class="card-body">
    
    
                            <div class="form-group col-12">
                                    <div class="row  justify-content-center col-12">
            
                                        <label for="Full name" class="pl-5  pr-5 col-3"><b>Height(feet/inch) </b><span
                                                style="color:red">*</span></label>
            
                                                <label for="ft" class="pr-3">Ft.</label>
                                                <input type="text" class="form-control w-100 col-4" id="inlineFormInputName2"
                                                placeholder="feet">
                                                <label for="in" class="pl-3 pr-3">In.</label>
                                                <input type="text" class="form-control w-100 col-4" id="inlineFormInputName2"
                                                placeholder="inch">
                
                                    </div>
                                </div>
    
                        <div class="form-group col-12">
                            <div class="row justify-content-center col-12">
    
                                <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Weight </b><span
                                        style="color:red">*</span></label>
    
                                        <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                                        placeholder="Enter your weight">
            
    
    
                            </div>
                        </div>  
                        
                        <div class="form-group col-12">
                                <div class="row  justify-content-center col-12">
        
                                    <label for="Full name" class="pl-5  pr-5 col-3"><b>Smoker </b></label>
                                    <select name="rel" id="rel" class="form-control search-select  mr-sm-3 ml-3 col-8"
                                    id="inlineFormInputName3">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                   
                                </select>
                                         
                                </div>
                            </div>   
                    </div>
            </div>

            <div class="card w-100 Card--custom__header">
                    <h5 class="card-header">If proposer is female </h5>
    
                    <div class="card-body">
    
                            <div class="form-group col-12">
                                    <div class="row  justify-content-center col-12">
            
                                        <label for="Full name" class="pl-5  pr-5 col-3"><b>Are you pregnant at present </b></label>
                                        <select name="rel" id="rel" class="form-control search-select  mr-sm-3 ml-3 col-8"
                                        id="inlineFormInputName3">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                       
                                    </select>
                                             
                                    </div>
                                </div>  
                            <div class="form-group col-12">
                                    <div class="row  justify-content-center col-12">
            
                                        <label for="Full name" class="pr-3 col-3"><b>Month and Year of Last Delivery </b></label>
            
                                               
                                                <input type="text" class="form-control w-100 col-8" id="inlineFormInputName2"
                                                placeholder="MM/YY">
                                               
                
                                    </div>
                                </div>
                    </div>
            </div>

            <div class="card w-100 Card--custom__header">
                    <h5 class="card-header">Child's Detail </h5>
                    <div class="card-body">
            <div class="form-group col-12">
                    <div class="row  justify-content-center col-12">

                        <input type="text" class="form-control w-100 col-4" id="inlineFormInputName2"
                        placeholder="Enter first name">
                        <input type="text" class="form-control w-100 col-3 ml-3" id="inlineFormInputName2"
                        placeholder="Enter middle name">
                        <input type="text" class="form-control w-100 col-4 mr-3 ml-3" id="inlineFormInputName2"
                        placeholder="Enter last name">

                             
                    </div>
                </div>  
                <div class="form-group col-12">
                        <div class="row  justify-content-center col-12">
        
                            <label for="Full name" class="col-3"><b>Gender </b><span
                                    style="color:red">*</span></label>
        
                            <select name="gender" id="gen" class="form-control search-select  mr-sm-3 ml-3 col-8 float-left"
                                id="inlineFormInputName3">
                                <option value="male">male</option>
                                <option value="female">female</option>
                                <option value="other">other</option>
                            </select>
        
        
                        </div>
                    </div>

                    <div class="form-group col-12">
                            <div class="row justify-content-center col-12">
    
                                <label for="Full name" class="pl-5 pb-0 pr-5 col-3"><b>Proof Of Age based on </b><span
                                        style="color:red">*</span></label>
    
                                        <select name="gender" id="gen" class="form-control search-select  mr-sm-3 ml-3 col-8"
                                        id="inlineFormInputName3">
                                        <option value="male">Birth Registration certificate</option>
                                        <option value="female">Medical certificate</option>
                                        
                                    </select>
    
    
                            </div>
                        </div>


            <div class="d-flex justify-content-end align-items-center" style="padding-right:95px;">
                <button type="reset" class="btn btn-md ml-5 btn-danger mb-2 submit">Clear All</button>

                <button type="submit" class="btn btn-md ml-2 btn-dark mb-2 submit">Proceed</button>
            </div>




        </div>
    </div>
</form>

@stop
