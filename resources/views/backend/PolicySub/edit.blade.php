@extends('layouts.backend.containerform')
@section('dynamicdata')
<div class="box box-primary">
  <h4 class="modal-title">Edit Policy Sub Category</h4>
  <button type="button" class="close pr-4" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="POST" action="{{ route('admin.policycategories.sub.update', $policy_sub_category->id) }}">
  {{ csrf_field() }}
  <div class="box-body">
    @include('layouts.backend.alert')
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label col-sm-3" for="policy_cat_id ">Policy Category:</label>
          <div class="">
            <select class="form-control" name="policy_cat_id" id="category">
              @foreach ($policy_categories as $policy_categorie)
              <option value="{{ $policy_categorie->id }}"
                {{ ($policy_categorie->id === $policy_sub_category->policy_cat_id ) ? 'selected' : '' }}>
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
          <label class="control-label col-sm-3" for="subcat_name">Policy Sub Category:</label>
          <div class="">
            <input type="text" class="form-control" name="subcat_name" value="{{ $policy_sub_category->subcat_name }}"
              autofocus>
          </div>
        </div>
      </div>
    </div><br>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label col-sm-3" for="content">Status:</label>
          <div class="">
            <select name="is_active" class="form-control">
              <option value="1" {{ ($policy_sub_category->is_active == 1) ? 'selected="selected"' : '' }}>Active
              </option>
              <option value="0" {{ ($policy_sub_category->is_active == 0) ? 'selected="selected"' : '' }}>Inactive
              </option>
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