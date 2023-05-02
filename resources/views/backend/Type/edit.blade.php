@extends('layouts.backend.containerform')
@section('dynamicdata')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Policy Type </h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form role="form" method="POST" action="{{ route('admin.policycategories.type.update', $type->id) }}">
    {{ csrf_field() }}
    <div class="box-body">
      @include('layouts.backend.alert')
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-sm-3" for="policy_cat_id ">Policy Category:</label>
            <div class="col-sm-9">
              <select class="form-control" name="policy_cat_id" id="category">
                @foreach ($policy_categories as $policy_categorie)
                <option value="{{ $policy_categorie->id }}"
                  {{ ($policy_categorie->id === $type->policy_cat_id ) ? 'selected' : '' }}>
                  {{ $policy_categorie->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-sm-3" for="subcat_id ">Policy Category:</label>
            <div class="col-sm-9">
              <select class="form-control" name="subcat_id" id="subcat_id">
                @foreach ($policy_sub_categories as $policy_sub_categorie)
                <option value="{{ $policy_sub_categorie->id }}"
                  {{ ($policy_sub_categorie->id === $type->subcat_id ) ? 'selected' : '' }}>
                  {{ $policy_sub_categorie->subcat_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-sm-3" for="type">Policy Type:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="type" value="{{ $type->type }}" autofocus>
            </div>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-sm-3" for="content">Status:</label>
            <div class="col-sm-9">
              <select name="is_active" class="form-control">
                <option value="1" {{ ($type->is_active == 1) ? 'selected="selected"' : '' }}>Active</option>
                <option value="0" {{ ($type->is_active == 0) ? 'selected="selected"' : '' }}>Inactive</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <input type="hidden" name="_method" value="PUT">
  </form>
</div>
@stop