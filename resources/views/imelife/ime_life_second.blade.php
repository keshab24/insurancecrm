@extends('layouts.backend.containerform')

@section('title')
<p class="h4 align-center mb-0">IME LIfe Insurance</p>
@endsection
@section('dynamicdata')
<div class="card m-3 Card--custom__header">
    <h5 class="card-header">Insurance Policy</h5>
    <div class="card m-3 Card--custom__header">
        <h5 class="card-header">Enter Insurance Detail</h5>

        <div class="card-body">

        <form class="form-inline" action="{{route('admin.ime.life.insurance.two')}}" method="post">
            @csrf
                <div class="form-group col-12">
                    <div class="row justify-content-center">
                        <div class="full-name">
                            <label for="Full name" class="pl-5 pr-5"><b>Select Plan </b><span
                                    style="color:red">*</span></label>
                        </div>
                      
                       <select name="gender" id="gen" class="form-control  mr-sm-3 ml-3" id="inlineFormInputName3">
                            @foreach($products as $product)
                       <option value="{{$product->id}}">{{$product->name}}</option>
                       @endforeach
                        </select>
                       
                    </div>
                </div>

                <div class="form-group col-12">
                        <div class="row justify-content-center">
                            <div class="full-name">
                                <label for="Full name" class="pl-5 pr-5"><b>Pay Mode </b><span
                                        style="color:red">*</span></label>
                            </div>
                          
                            <select name="loading_charge" id="laoding" class="form-control ml-3">
                                    <option selected>yearly</option>
                                    <option>half_yearly</option>
                                    <option>quarterly</option>
                                    <option>monthly</option>
                                </select>
                           
                        </div>
                    </div>


                    <div class="form-group col-12">
                            <div class="row justify-content-center">
                                <div class="full-name">
                                    <label for="Full name" class="pl-5 pr-5"><b>Rider </b><span
                                            style="color:red">*</span></label>
                                </div>
                              
                                <select name="loading_charge" id="laoding" class="form-control ml-5">
                                        <option selected>yes</option>
                                        <option>no</option>
                                    </select>
                               
                            </div>
                        </div>

                        <div class="form-group col-12">
                                <div class="row justify-content-center">
                                    <div class="full-name">
                                        <label for="Full name" class="pl-5 pr-5"><b>Occupation </b><span
                                                style="color:red">*</span></label>
                                    </div>
                                  
                                    <select name="occupation" id="laoding" class="form-control ">
                                            <option selected>Teacher</option>
                                            <option>officer</option>
                                        </select>
                                   
                                </div>
                            </div>

                            <div class="form-group col-12">
                                    <div class="row justify-content-center">
                                        <div class="full-name">
                                            <label for="Full name" class="pl-5 pr-5"><b>Sum Assured </b><span
                                                    style="color:red">*</span></label>
                                        </div>
                                      
                                        <select name="sum" id="laoding" class="form-control ">
                                                <option selected>25000</option>
                                                <option>1000000</option>
                                            </select>
                                       
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                        <div class="row justify-content-center">
                                            <div class="full-name">
                                                <label for="Full name" class="pl-5 pr-4"><b>Policy Term Year </b><span
                                                        style="color:red">*</span></label>
                                            </div>
                                          
                                            <select name="sum" id="laoding" class="form-control ">
                                                    <option selected>5</option>
                                                    <option>10</option>
                                                    <option>15</option>
                                                    <option>20</option>
                                                </select>
                                           
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                            <div class="row justify-content-center">
                                                <div class="full-name">
                                                    <label for="Full name" class="pl-4 pr-4"><b>Premium Term Year </b><span
                                                            style="color:red">*</span></label>
                                                </div>
                                              
                                                <select name="premium" id="laoding" class="form-control ">
                                                        <option selected>5</option>
                                                        <option>10</option>
                                                    </select>
                                               
                                            </div>
                                        </div>
             

                                        
                <button type="button" class="btn btn-md ml-5 btn-dark mb-2 submit" onclick="window.location='{{ url("/ime-life-insurance") }}'">Back</button>

                <button type="reset" class="btn btn-md ml-2 btn-danger mb-2 submit">Clear All</button>

                <button type="submit" class="btn btn-md ml-2 btn-dark mb-2 submit" >Proceed</button>


            </form>
        </div>
    </div>
</div>

                @stop
