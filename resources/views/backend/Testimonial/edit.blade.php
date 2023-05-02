@section('header_css')
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}">
    <style>
        .rates {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rates:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rates:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:38px;
            color:#ccc;
        }
        .rates:not(:checked) > label:before {
            content: '★ ';
        }
        .rates > input:checked ~ label {
            color: #f79633;
        }
        .rates:not(:checked) > label:hover,
        .rates:not(:checked) > label:hover ~ label {
            color: #f79633;
        }
        .rates > input:checked + label:hover,
        .rates > input:checked + label:hover ~ label,
        .rates > input:checked ~ label:hover,
        .rates > input:checked ~ label:hover ~ label,
        .rates > label:hover ~ input:checked ~ label {
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
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Edit Testimonial</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('testimonial.update',['testimonial'=>$testimonial['id']])}}"
                  enctype="multipart/form-data">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputFile">Select Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" >
                    <p class="help-block">File Must Be In '.png' Image Format. Insert Image of 3 X 3</p>
                    <div class="gallery-img">
                            <img class="img-responsive"
                                 src="{{$testimonial['image']}}" alt="Testimonial image">
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" value="{{$testimonial['name']}}" class="form-control"
                           placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="title">Designation</label>
                    <input type="text" value="{{$testimonial['designation']}}" name="designation" class="form-control"
                           placeholder="Enter Designation" required>
                </div>
                <div class="form-group">
                    <label for="description">Comment</label>
                    <textarea name="comment" class="form-control" cols="5"
                    <textarea name="comment" class="form-control" cols="5"
                              rows="10">{{$testimonial['comment']}}</textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <div class="form-group col-12">
                        <div class="rates">
                            <input type="radio" name="rating" value="5" {{$testimonial['rating'] == 5 ? "checked" : ''}}/>
                            <label for="star5" title="text">5 stars</label> &nbsp;
                            <input type="radio" name="rating" value="4" {{$testimonial['rating'] == 4 ? "checked" : ''}}/>
                            <label for="star4" title="text">4 stars</label> &nbsp;
                            <input type="radio" name="rating" value="3" {{$testimonial['rating'] == 3 ? "checked" : ''}}/>
                            <label for="star3" title="text">3 stars</label> &nbsp;
                            <input type="radio" name="rating" value="2" {{$testimonial['rating'] == 2 ? "checked" : ''}}/>
                            <label for="star2" title="text">2 stars</label> &nbsp;
                            <input type="radio" name="rating" value="1" {{$testimonial['rating'] == 1 ? "checked" : ''}}/>
                            <label for="star1" title="text">1 star</label> &nbsp;
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
