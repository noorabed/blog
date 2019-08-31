@php
    $views=\App\Blog::orderBy('view_count','desc')->get();
    $categories=\APP\Category::orderBy('title','asc')->get();

@endphp

<div class="col-md-4">

    <aside class="right-sidebar">
        <div class="search-widget">
            <form action="{{route('blogs.show')}}">
                @csrf
                <div class="input-group">
                <input type="text" class="form-control input-lg" value="{{request('term')}}" name="term" placeholder="Search for...">
                <span class="input-group-btn">
                            <button class="btn btn-lg btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                          </span>
            </div><!-- /input-group -->
            </form>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Categories</h4>
            </div>
            <div class="widget-body">
                <ul class="categories">
                   @foreach ( $categories as $category)
                        <li>
                            <a href="{{ route('category', $category->slug) }}"><i class="fa fa-angle-right"></i> {{ $category->title }} </a>
                            <span class="badge pull-right">{{ $category->posts->count() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Popular Posts</h4>
            </div>
            <div class="widget-body">
                <ul class="popular-posts">
                    @foreach ($views as $blog)
                        <li>
                                <div class="post-image">
                                    <a href="{{ route('blogs.view', $blog->id) }}">
                                        <img src="{{ asset('image/'.$blog->post_photo )}}"  style="height: 56px"/>
                                    </a>
                                </div>

                            <div class="post-body">
                                <h6><a href="{{ route('blogs.view', $blog->id) }}">{{ $blog->post_tittle }}</a></h6>
                                <div class="post-meta">
                                    <span>{!! str_limit($blog->post_descripition,40) !!}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


        <div class="widget">
            <div class="widget-heading">
                <h4>Tags</h4>
            </div>
            <div class="widget-body">

                <ul class="tags">
                    @foreach ($tags as $tag)
                    <li><a href="{{route('tag',$tag->second_name)}}">{{$tag->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </aside>
</div>