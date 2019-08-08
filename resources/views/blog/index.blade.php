@extends('layouts.main')

@section('content')


        <div class="col-md-8">
            @foreach($blogs as $blog)
            <article class="post-item"}>
                <div class="post-item-image">
                    <a href="{{ route('blogs.view',$blog->id)}}">
                        <img src="{{ URL::to('/') }}/image/{{$blog->post_photo}}" style="height: 400px;" alt="">
                    </a>
                </div>
                <div class="post-item-body">
                    <div class="padding-10">
                        <h2><a href="{{ route('blogs.view', $blog->id) }}}">{{$blog->post_tittle}}</a></h2>
                        <p>{!! str_limit($blog->post_descripition,100) !!}</p>
                    </div>

                    <div class="post-meta padding-10 clearfix">
                        <div class="pull-left">
                            <ul class="post-meta-group">
                                <li><i class="fa fa-user"></i><a href="{{ route('blogs.view', $blog->id) }}"> {{ @ $blog->user->name}}</a></li>
                                <li><i class="fa fa-clock-o"></i><time>{{ date('F d, Y',  strtotime($blog->created_at)) }}</time></li>
                                <li><i class="fa fa-tags"></i><a href="#"> Vue Js</a>, <a href="#"> Laravel</a></li>
                                <li><i class="fa fa-comments"></i><a href="#">4 Comments</a></li>
                            </ul>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('blogs.view',$blog->id)}}" >Continue Reading &raquo;</a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
            <nav>
                <ul class="pager">
                    <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Newer</a></li>
                    <li class="next"><a href="#">Older <span aria-hidden="true">&rarr;</span></a></li>
                </ul>
            </nav>
        </div>

{{--        @include('layouts.sidebar')--}}

    @endsection

