@extends('layouts.backend.containerlist')

@section('dynamicdata')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Edit Age Difference </h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')
        <form action="{{ route('age-difference.update', $ageDifference->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <!-- Companies -->
                <div class="form-group col-12 col-md-6">
                       <input type="hidden" class="form-control" value="{{$ageDifference->company_id}}" name="company_id">
                    Company: {{ $ageDifference->company->name }}
                </div>

                <!-- Products -->
                <div class="form-group col-12 col-md-6">
                    <input type="hidden" class="form-control" value="{{$ageDifference->product_id}}" name="product_id">
                    Product: {{ $ageDifference->product->name }}
                </div>

                <!-- Terms-->
                <div class="form-group col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Age Difference Between Husband And Wife</span>
                        </div>
                        <input type="number" class="form-control @error('age_difference') is-invalid @enderror"
                            name="age_difference" id="age_difference" value="{{  $ageDifference->age_difference }}"
                            placeholder="Difference in age.">
                    </div>
                </div>

                <div class="form-group  col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Additional Age for smaller aged</span>
                        </div>
                        <input type="number" class="form-control @error('add_age') is-invalid @enderror" name="add_age"
                            id="add_age" value="{{ $ageDifference->add_age }}" placeholder="Age to be added.">
                    </div>
                    @error('add_age')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop
