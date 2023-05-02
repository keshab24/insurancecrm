@extends('layouts.backend.containerlist')

@section('dynamicdata')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Edit General Setting</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')
        <form class="px-3" action="{{ route('general-setting.update', $setting->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="key">Key</label>
                <input type="text" class="form-control @error('key') is-invalid @enderror" name="key" id="key"
                    value="{{ $setting->key }}" placeholder="Setting Key Eg: mail-from">
                @error('key')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" id="value"
                    value="{{ $setting->value }}" placeholder="Setting Value Eg: abc@xyz.com">
                @error('value')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type"
                    value="{{ $setting->type }}" placeholder="Setting Type Eg: mail-settings">
                @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop
