    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Association</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('association.update',['association'=>$association['id']])}}"
                      enctype="multipart/form-data">
                    {{method_field('patch')}}
                    {{csrf_field()}}
                        <div class="form-group">
                            <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                            <p><input type="file" class="form-control"  accept="image/*" name="image"  onchange="loadFile(event)"></p>
                            <p><img id="output" width="200" /></p>
                            <p class="help-block">File Must Be In Image Format. Insert Image of 3 X 2</p>
                            <div class="gallery-img">
                                    <img class="img-responsive"
                                         src="{{$association['image']}}" alt="Association Image">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" value="{{$association['name']}}" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="title">Category</label>
                            <select class="form-control" name="association_type">
                                <option value="1" {{$association['association_type'] == 1 ? 'selected' : ''}}>Life Insurance</option>
                                <option value="2" {{$association['association_type'] == 2 ? 'selected' : ''}}>Non Life Insurance</option>
                            </select>
                        </div>
                        <div style="clear: both">
                            <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
@section('footer_js')
<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection
