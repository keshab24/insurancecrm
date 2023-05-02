@extends('layouts.backend.containerlist')

@section('dynamicdata')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Add General Setting</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')
        <form class="px-3" action="{{ route('general-setting.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="key">Key</label>
                <input type="text" class="form-control @error('key') is-invalid @enderror" name="key" id="key"
                    value="{{ old('key') }}" placeholder="Setting Key Eg: mail-from">
                @error('key')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" id="value"
                    value="{{ old('value') }}" placeholder="Setting Value Eg: abc@xyz.com">
                @error('value')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type"
                    value="{{ old('type') }}" placeholder="Setting Type Eg: mail-settings">
                @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="is_deletable">Deletable</label>
                <select class="form-control @error('is_deletable') is-invalid @enderror" name="is_deletable" id="is_deletable">
                    <option value="1" selected>Yes</option>
                    <option value="0" @if(old('is_deletable') == 0) selected @endif>No</option>
                </select>
                @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop
