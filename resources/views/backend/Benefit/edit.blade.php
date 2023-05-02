@extends('layouts.backend.containerlist')

@section('dynamicdata')

    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Edit Benefit </h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            <form action="{{ route('benefit.update', $benefit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <!-- Companies -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Company</span>
                            </div>
                            <select
                                class="form-control search-select @error('company_id') is-invalid @enderror"
                                id="companies"
                                name="company_id"
                            >
                                <option selected disabled>Select a company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if($benefit->company_id == $company->id) selected @endif>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group  col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Benefit Name</span>
                            </div>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                id="name"
                                value="{{ $benefit->name }}"
                                placeholder="Benefit Name"
                            >
                        </div>
                    </div>

                    <div class="form-group  col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Product Category</span>
                            </div>
                            <select
                                name="category"
                                id="category"
                                class="form-control @error('category') is-invalid @enderror"
                            >
                                <option value="dhan-bristi" @if($benefit->category == 'dhan-bristi') selected @endif>
                                    Dhan Bristi
                                </option>
                                <option value="endowment" @if($benefit->category == 'endowment') selected @endif>
                                    Endowment
                                </option>
                                <option value="pension" @if($benefit->category == 'pension') selected @endif>Pension
                                </option>
                                <option value="money-back" @if($benefit->category == 'money-back') selected @endif>Money
                                    Back
                                </option>
                                <option value="whole-life" @if($benefit->category == 'whole-life') selected @endif>Whole
                                    Life
                                </option>
                                <option value="term" @if($benefit->category == 'term') selected @endif>Term</option>
                                <option value="retirement-pension"
                                        @if($benefit->category == 'retirement-pension') selected @endif>
                                    Retirement-Pension
                                </option>
                                <option value="education" @if($benefit->category == 'education') selected @endif>
                                    Education
                                </option>
                                <option value="children" @if($benefit->category == 'children') selected @endif>
                                    Children
                                </option>
                                <option value="couple" @if($benefit->category == 'couple') selected @endif>Couple
                                </option>
                            </select>
                        </div>
                        @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop
