@extends('layouts.main')

@section('content')


        <div class="col-md-8">
            @if(! $blogs->count())
            <div class="alert alert-danger">
                <p> Nothing Found any Post here</p>
            </div>
                @else
                @include('blog.alert')
                @foreach($blogs as $blog)
                    <article class="post-item"}>
                        <div class="post-item-image">
                            <a href="{{ route('blogs.view',$blog->id)}}">
                                <img src="{{ URL::to('/') }}/image/{{$blog->post_photo}}" style="width: 100%;height:30%;" alt="">
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
                                       {{-- <time>{{ date('F d, Y',  strtotime($blog->created_at))}}</time>--}}
                                        <li><i class="fa fa-clock-o"></i>{{$blog->created_at->diffForHumans()}}</li>
                                        <li><i class="fa fa-folder"></i><a href="#">{{ @ $blog->category->title}}</a></li>
                                        <li><i class="fa fa-tags"></i>{!! $blog->tags_html !!}</li>
                                        <li><i class="fa fa-comments"></i><a href="{{ route('blogs.view',$blog->id)}}#post-comments">{{$blog->commentsNumber()}}</a></li>
                                    </ul>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('blogs.view',$blog->id)}}" >Continue Reading &raquo;</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                @endif

          <nav>
              {{$blogs->links()}}
          </nav>

        </div>

{{--        @include('layouts.sidebar')--}}

    @endsection



