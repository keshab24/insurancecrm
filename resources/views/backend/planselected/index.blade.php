@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Selected Plans</p>
@endsection

@section('footer_js')
    <script type="text/javascript">
        var oTable = $('#whyTable').dataTable();
        $('#tablebody').on('click', '.delete-item', function (e) {
            e.preventDefault();
            $object = $(this);
            var id = $object.attr('id');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/why-us') }}" + "/" + id,
                    data: {
                        'id': id,
                        _method: 'delete'
                    },
                    dataType: 'json',
                    success: function (response) {
                        var nRow = $($object).parents('tr')[0];
                        oTable.fnDeleteRow(nRow);
                        swal('Success', response.message, 'success');
                    },
                    error: function (e) {
                        swal('Oops...', 'Something went wrong!', 'error');
                    }
                });
            });
        });
    </script>
@endsection

@section('dynamicdata')

    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
            </div>
        </div>
        <div class="box-body">

            @include('layouts.backend.alert')
      
            <hr>
           
              {{--  <div class="justify-content-end list-group list-group-horizontal ">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#addModal"><img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon">&nbsp;
                        Add
                    </button>
                    @include('backend.WhyUs.add')
                </div>--}}
        
            <br>
            <div class="blank-page">
                <table class="table" id="whyTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Term</th>
                        <th scope="col">Product Description</th>
                        <th scope="col">Sum Assured</th>
                        <th scope="col">Mop</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Premium on compare</th>
                        <th scope="col">Bonus</th>
                        <th scope="col">full name</th>
                        <th scope="col">phone number</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">
                    @foreach($selected as $sel)
                        <tr id="row_{{ $sel->id }}">

                            <th scope="row">{{$loop->iteration}}</th>
                           
                            <td>
                                {{$sel->name}}
                            </td>
                            <td>{{$sel->age}}</td>
                            <td>
                               {{$sel->term}}
                        
                            </td>
                            <td>
                                {{$sel->planproduct->name}}({{$sel->planproduct->company->name}})
                         
                             </td>
                             <td>
                                {{$sel->sum_assured}}
                         
                             </td>
                             <td>
                                {{$sel->mop}}
                         
                             </td>
                             <td>
                                {{$sel->birth_date}}-{{$sel->birth_month}}-{{$sel->birth_year}}
                         
                             </td>
                             <td>
                                Rs. {{$sel->premium}}
                             </td>
                             <td>
                                Rs. {{$sel->bonus}}
                             </td>
                             <td>
                                 {{$sel->fname}}  {{$sel->lname}}
                             </td>
                             <td>
                                {{$sel->phone}}
                             </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
