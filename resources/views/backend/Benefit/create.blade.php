@extends('layouts.backend.containerlist')

@section('dynamicdata')

    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Add Benefit</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            <form action="{{ route('benefit.store') }}" method="POST">
                @csrf

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
                                    <option value="{{ $company->id }}">
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
                                value="{{ old('name') }}"
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
                                <option selected disabled>Select a category</option>
                                <option value="dhan-bristi">Dhan Bristi</option>
                                <option value="endowment">Endowment</option>
                                <option value="pension">Pension</option>
                                <option value="money-back">Money Back</option>
                                <option value="whole-life">Whole Life</option>
                                <option value="term">Term</option>
                                <option value="retirement-pension">Retirement-Pension</option>
                                <option value="education">Education</option>
                                <option value="children">Children</option>
                                <option value="couple">Couple</option>
                            </select>
                        </div>
                        @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@stop
