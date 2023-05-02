@extends('layouts.backend.containerlist')

@section('dynamicdata')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">EDIT social links</h3>
    </div>
    <div class="box-body">
        @include('layouts.backend.alert')
        <form class="px-3" action="{{ route('social-link.update', $link->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    value="{{ $link->title }}" placeholder="Social Media Title">
                @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                    value="{{ $link->link }}" placeholder="Place your link address">
                @error('link')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="icon">Icon</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon"
                    value="{{ $link->icon }}" placeholder="icon">
                @error('icon')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="number" class="form-control @error('position') is-invalid @enderror" name="position"
                    id="position" value="{{ $link->position }}" placeholder="position">
                @error('position')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="is_active">Status</label>
                <select class="form-control @error('is_active') is-invalid @enderror" name="is_active" id="is_active">
                    <option value="0" @if ($link->is_active == 0)
                        selected
                        @endif >inactive</option>
                    <option value="1" @if ($link->is_active == 1)
                        selected
                        @endif >active</option>
                </select>
                @error('is_active')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop
