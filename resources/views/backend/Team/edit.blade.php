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
            <h4>Edit Team</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('team.update',['team'=>$testimonial['id']])}}"
                  enctype="multipart/form-data">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputFile">Select Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" id="exampleInputFile">
                    <p class="help-block">File Must Be In '.png' Image Format. Insert Image of 3 X 3</p>
                    <div class="gallery-img">
                            <img class="img-responsive"
                                 src="{{$testimonial['image']}}" alt="Team image">
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" value="{{$testimonial['name']}}" class="form-control" id="title"
                           placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="title">Designation</label>
                    <input type="text" value="{{$testimonial['designation']}}" name="designation" class="form-control"
                           placeholder="Enter Designation" required>
                </div>
                <div class="form-group">
                    <label for="title">fb link</label>
                    <input type="text" value="{{$testimonial['fb']}}" name="fb" class="form-control"
                           placeholder="Enter fb link">
                </div>
                <div class="form-group">
                    <label for="title">twitter link</label>
                    <input type="text" value="{{$testimonial['twitter']}}" name="twitter" class="form-control"
                           placeholder="Enter twitter link">
                </div>
                <div class="form-group">
                    <label for="title">linkedin link</label>
                    <input type="text" value="{{$testimonial['linkedin']}}" name="linkedin" class="form-control"
                           placeholder="Enter linkedin link">
                </div>
               
                <div style="clear: both">
                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
