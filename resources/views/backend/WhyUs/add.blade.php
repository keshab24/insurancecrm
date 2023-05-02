<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Why Us Content</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('why-us.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                        <p><input type="file" class="form-control" accept="image/*" name="image" id="file"
                                  onchange="loadFile(event)" required></p>
                        <p><img id="output" width="200"/></p>
                        <p class="help-block">File Must Be In '.png' Image Format. Insert Image of 3 X 2</p>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" value="{{old('title')}}" name="title" class="form-control"
                               placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="description">Comment</label>
                        <textarea name="description" value="{{old('description')}}" class="form-control" cols="5" rows="10"></textarea>
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
</div>
@section('footer_js')
    <script>
        var loadFile = function (event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
