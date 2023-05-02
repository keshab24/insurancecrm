@section('header_css')
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:38px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #f79633;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #f79633;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #f79633;
        }
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
                <h4>Add Testimonial</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                    <form method="POST" action="{{route('testimonial.store')}}" enctype="multipart/form-data">
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
                            <label for="description">Comment</label>
                            <textarea name="comment" value="{{old('comment')}}" class="form-control" cols="5" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="form-group col-12">
                                <div class="rate">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                            </div>
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
