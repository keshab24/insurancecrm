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

<form class="form-inline">
    @csrf


    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Details Of Plan</h5>

        <div class="card-body">
            <div class="form-group col-12">
                <div class="row col-12">
                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Policy Number</th>
                                <td class="index">
                                    <b>29393942</b>
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Plan<span style="color:black">*</span></th>
                                <td class="index">
                                    <b>
                                        SIMPLE ENDOWMENT</b>
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Sum Assured</th>
                                <td class="index font-weight-bold">
                                    25000
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Date of Birth life to be Assured</th>
                                <td class="index font-weight-bold">
                                    2052/10/11
                                </td>
                                <td class="index font-weight-bold">
                                    1995/1/2
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Mode</th>
                                <td class="index font-weight-bold">
                                    Monthly
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Policy Term Year</th>
                                <td class="index font-weight-bold">
                                    3
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Premium Term Year</th>
                                <td class="index">
                                    4
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Rider(ADB/PTD/PWB)</th>
                                <td class="index font-weight-bold">
                                    ADB
                                </td>
                            </tr>

                        </tbody>
                        </thead>
                    </table>

                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Occupation</th>
                                <td class="index">
                                    Teacher
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>User's ID</th>
                                <td class="index">
                                    2534
                                </td>
                            </tr>
                            <div class="float-left">
                                <h4>Occupational Details</h4>
                            </div>

                        </tbody>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>



    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Branch Code/Proposal Number</h5>

        <div class="card-body">
            <div class="form-group col-12">
                <div class="row justify-content-center col-12">
                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Branch Name/Code<span style="color:black">*</span></th>
                                <td class="index">
                                    Panipokhari
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Proposal Date</th>
                                <td class="index">
                                    2014-2-1
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Proposal Number</th>
                                <td class="index">
                                    2052/10/11
                                </td>

                            </tr>

                            <tr class="gradeX">
                                <th>Agency Code/name</th>
                                <td class="index">
                                    Monthly
                                </td>
                                <td class="index">
                                    Monthly
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>User's ID</th>
                                <td class="index">
                                    3
                                </td>
                            </tr>


                        </tbody>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Deatails of Life to be Assured/Proposer</h5>

        <div class="card-body">

            <div class="form-group col-12">
                <div class="row justify-content-center col-12">
                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Name(English)</th>
                                <td class="index">
                                    Aakreeti Pyakurel
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Gender</th>
                                <td class="index">
                                    female
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Address(permanent)</th>
                                <td class="index">
                                    Hatigauda
                                </td>

                            </tr>

                            <tr class="gradeX">
                                <th>Mobile No</th>
                                <td class="index">
                                    9843232312
                                </td>

                            </tr>

                            <tr class="gradeX">
                                <th>Present Address</th>
                                <td class="index">
                                    Putalisadak
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Education Qualification</th>
                                <td class="index">
                                    Bachelor
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Age proof</th>
                                <td class="index">
                                    32
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Id/Citizenship No</th>
                                <td class="index">
                                    2344
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Nominee Name</th>
                                <td class="index">
                                    Hari Pyakurel
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>Relationship with nominee</th>
                                <td class="index">
                                    Father
                                </td>
                            </tr>


                        </tbody>
                        </thead>
                    </table>


                </div>
            </div>
        </div>
    </div>


    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Childre's Detail(Incase of Child Plan)</h5>

        <div class="card-body">


            <div class="form-group col-12">
                <div class="row justify-content-center col-12">
                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Name of child</th>
                                <td class="index">
                                    Sonu pyakurel
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Gender</th>
                                <td class="index">
                                    female
                                </td>
                            </tr>


                            <tr class="gradeX">
                                <th>Age proof</th>
                                <td class="index">
                                    13
                                </td>
                            </tr>

                        </tbody>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="card w-100 Card--custom__header">
        <h5 class="card-header">Personal Health Statement</h5>

        <div class="card-body">


            <div class="form-group col-12">
                <div class="row col-12">
                    <table id="tablebody" class="table table-striped table-hover">
                        <thead>
                        <tbody>
                            <tr class="gradeX">
                                <th>Height</th>
                                <td class="index">
                                    5 Feet 4 Inch
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Weight</th>
                                <td class="index">
                                    56
                                </td>
                            </tr>


                            <tr class="gradeX">
                                <th>Smoker</th>
                                <td class="index">
                                    yes
                                </td>
                            </tr>
                            <tr class="gradeX">
                                <th>If life to be Assured/Proposer is female</th>
                            </tr>
                            <tr class="gradeX">
                                <th>Are You pregnant at present?</th>
                                <td class="index">
                                    yes
                                </td>
                            </tr>

                            <tr class="gradeX">
                                <th>Month and Year of Last Delivery</th>
                                <td class="index">
                                    05-1996
                                </td>
                            </tr>

                        </tbody>
                        </thead>
                    </table>
                </div>


                <label for="file_input" class="float-left"><b>File Input</b></label>

                <div class="row col-12">
                    <input type="file" name="file" class="col-9" id="">
                </div>
            </div>




            <div class="d-flex justify-content-end align-items-center confirm" style="padding-right:95px;">
                <button type="" class="btn btn-md ml-5 btn-danger submit">Upload Now</button>

                {{-- <button> --}}
                <button type="submit" class="btn btn-md ml-3 btn-dark submit">Skip Now and Upload Later</button>
                {{-- </button> --}}


            </div>

        </div>
</form>
<div id="confirmModal" class="modal left fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header remarks-add-header">
                <h4 class="modal-title float-left">Confirmation</h4>

            </div>
            <div class="modal-body container">
                <form class="form" action="{{ route('admin.ime.life.insurance.five') }}"
                    method="post">
                    @csrf
                    <p class="card-text font-weight-bold">Based On the information you provided the yearly insurance
                        premium comes up to be</p>
                    <h5 class="card-title font-weight-bold">Rs.23,500</h5>
                    <p class="card-text font-weight-bold">To continue purchasing policy click Proceed, or press Cancel
                        to cancel</p>


                    <button type="submit" class="btn btn-md ml-5 btn-dark mb-2 submit">Proceed</button>

                    <button type="submit" class="btn btn-md ml-2 btn-danger mb-2 submit">Cancel</button>

            </div>
        </div>
    </div>
</div>

@stop
