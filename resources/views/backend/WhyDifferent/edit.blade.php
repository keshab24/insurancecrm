@section('header_css')
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}">
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
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Edit Why Different Content</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('why-different.update',$why['id'])}}"
                  enctype="multipart/form-data">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputFile">Select Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <p class="help-block">File Must Be In '.png' Image Format. Insert Image of 3 X 3</p>
                    <div class="gallery-img">
                            <img class="img-responsive"
                                 src="{{$why->image}}" alt="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{$why['title']}}" class="form-control"
                           placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" cols="5"
                              rows="10">{{$why['description']}}</textarea>
                </div>
                <div style="clear: both">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
