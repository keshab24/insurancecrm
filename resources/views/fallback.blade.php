@extends('frontend.layouts.app')

@section('css')
    <style type="text/css">
        #error404 #titleWrapper {
            background-image: url(/images/error-icon.png),url(/images/background.jpg);
            background-repeat: repeat-x;
            background-position: left 563px,center -160px;
            height: 573px;
        }
        #titleWrapper {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAA8CAYAAAAUufjgAAABJElEQVR42u3S0anCQBCFYUtICZaQElJCSthSpoOUkBIsYUuwBEsQ7st9usw9hoEFDyKsMbsPZ+CPEhP8GPb08/t3QadWufvL8Ls9Lo6W5kDGJeQbMEptgYwrwJK1ATKOgaUVDS2AsSBnIHdF41FAfJ5RJgcBueWAbRq6I68BerxsO0MHlNCt/E8tkM/n/AFsQittbBcgl5HFJqanMzvGvTmeyS9Q74HufSeggAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACCvhF4KVjoOGyzdIhLiF8KZN6wxVgGesFV4A8Kxoa4Qw5A3muaDwQdkaZFATkWQ7YpqE78hqgx8u2M3RACd08ph7I53P+ADahlTa2C5AnI4tNTE9ndox7czyTN1TF/AMvH9/X9zC8FAAAAABJRU5ErkJggg==),url(../../themes/public/core/layout/images/background.jpg);
            background-repeat: repeat-x;
            background-position: left 163px,center -560px;
            height: 173px;
        }
        .container-error {
            width: 896px;
            margin: 0 auto;
        }
        #title {
            position: relative;
        }
        #error404 #title h1 {
            text-indent: -9999px;
            padding: 0;
            margin: 0;
            height: 573px;
            width: 896px;
            background: url(/images/title_404.png) no-repeat top center;
        }
        #title h1, #title h2 {
            font-family: 'Geometr231Bold',Arial,sans-serif;
            line-height: 1.72;
            font-weight: 300;
            color: #fff;
            font-size: 100px;
            padding: 0;
            text-shadow: 0px 1px 0 rgb(0 0 0 / 33%);
        }
        #main {
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div id="error404" class="en">

        <div id="topWrapper">
            <header id="header" role="banner">
                <div id="titleWrapper">
                    <div class="container container-error">

                        <div id="title">
                            <h1>404</h1>
                        </div>
                    </div>
                </div>
            </header>

            <div id="main" role="main">
            </div>
        </div>

    </div>
@stop
