@extends('layouts.backend.containerform')
@section('dynamicdata')
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit LeadType</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('admin.leadcategories.leadtypes.update', $leadtype->id) }}">
              {{ csrf_field() }}
              <div class="box-body">
                @include('layouts.backend.alert')
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label " for="type">Lead Type :</label>
                        <div class="">
                            <input type="text" class="form-control" name="type" value="{{ $leadtype->type }}" autofocus>
                        </div>
                      </div>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                            <label class="control-label " for="content">Status:</label>
                            <div class="">
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ ($leadtype->is_active == 1) ? 'selected="selected"' : '' }}>Active</option>
                                    <option value="0" {{ ($leadtype->is_active == 0) ? 'selected="selected"' : '' }}>Inactive</option>
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
