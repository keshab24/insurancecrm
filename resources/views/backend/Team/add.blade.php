@section('header_css')
    <style>
        .img-responsive{
            max-width: 100%;
        }
        .gallery-img{
            height: 150px;
            width: 150px;
        }
    </style>
@endsection

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Team</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                    <form method="POST" action="{{route('team.store')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                            <p><input type="file" class="form-control" accept="image/*" name="image" id="file"  onchange="loadFile(event)" required></p>
                            <p><img id="output" width="200" /></p>
                            <p class="help-block">File Must Be In '.png' Image Format. Insert Image of 3 X 3</p>
                        </div>
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" value="{{old('name')}}" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Designation</label>
                            <input type="text" value="{{old('designation')}}" name="designation" class="form-control" placeholder="Enter Designation" required>
                        </div>
                        <div class="form-group">
                            <label for="title">fb link</label>
                            <input type="text" value="{{old('fb')}}" name="fb" class="form-control" placeholder="Enter facebook link">
                        </div>
                        <div class="form-group">
                            <label for="title">twitter link</label>
                            <input type="text" value="{{old('twitter')}}" name="twitter" class="form-control" placeholder="Enter twitter link">
                        </div>
                        <div class="form-group">
                            <label for="title">linkedin link</label>
                            <input type="text" value="{{old('linkedin')}}" name="linkedin" class="form-control" placeholder="Enter linkedin link">
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
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endsection
