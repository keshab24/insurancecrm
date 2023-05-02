@php
    $name = Request::segment(3);
    $id = Request::segment(4);
@endphp

<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumb" style="background:white;">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @foreach($breadcrumbs as $i => $breadcrumb) 
                @if ($breadcrumb == end($breadcrumbs))
                    <li class="active">
                        {!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}
                    </li>
                @else 
                    @if(Request::segment(6) != null && Request::segment(6) == 'create')
                        
                        @if($i == 3)
                            @if(array_key_exists('slug', $breadcrumb))

                                @if($name == 'album')
                                    <li>
                                        <a href="{!! url('admin/media/album/'. $id .'/photo') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @elseif($name == 'about-us')
                                    <li>
                                        <a href="{!! url('admin/media/about-us/'. $id .'/photo') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @endif

                            @endif
                        @else
                            @if(array_key_exists('slug', $breadcrumb))
                                    
                                @if($name == 'album')
                                    <li>
                                        <a href="{!! url('admin/media/album') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @elseif($name == 'about-us')
                                    <li>
                                        <a href="{!! url('admin/media/about-us') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @endif
                               
                            @endif
                        @endif

                    @elseif(Request::segment(7) != null && Request::segment(7) == 'edit')

                        @if($i == 3)
                            @if(array_key_exists('slug', $breadcrumb))

                                @if($name == 'album')
                                    <li>
                                        <a href="{!! url('admin/media/album/'. $id .'/photo') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @elseif($name == 'about-us')
                                    <li>
                                        <a href="{!! url('admin/media/about-us/'. $id .'/photo') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @endif

                            @endif
                        @else
                            @if(array_key_exists('slug', $breadcrumb))

                                @if($name == 'album')
                                    <li>
                                        <a href="{!! url('admin/media/album') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @elseif($name == 'about-us')
                                    <li>
                                        <a href="{!! url('admin/media/about-us') !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                                    </li>
                                @endif

                            @endif
                        @endif

                    @else 
                        @if(array_key_exists('slug', $breadcrumb))
                            <li>
                                <a href="{!! route($breadcrumb['slug']) !!}">{!! ucwords(str_replace('-', ' ', $breadcrumb['name'])) !!}</a>
                            </li>
                        @endif 
                    @endif
                @endif 
            @endforeach
        </ul>
    </div>
</div>