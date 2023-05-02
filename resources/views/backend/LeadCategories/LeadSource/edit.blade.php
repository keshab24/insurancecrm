@extends('layouts.backend.containerform')
@section('dynamicdata')
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit LeadSource</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('admin.leadcategories.leadsource.update', $leadsource->id) }}">
              {{ csrf_field() }}
              <div class="box-body">
                @include('layouts.backend.alert')
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">Lead Source Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ $leadsource->name }}" autofocus>
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
                                    <option value="1" {{ ($leadsource->is_active == 1) ? 'selected="selected"' : '' }}>Active</option>
                                    <option value="0" {{ ($leadsource->is_active == 0) ? 'selected="selected"' : '' }}>Inactive</option>
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
