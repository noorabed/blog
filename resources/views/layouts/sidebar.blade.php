@php
    $views=\App\Blog::orderBy('view_count','desc')->take(3)->get();
    $categories=\APP\Category::orderBy('title','asc')->get();

@endphp

<div class="col-md-4">

    <aside class="right-sidebar">
        <div class="search-widget">
            <div class="form-group">
                <input type="text" name="post_tittle" id="post_tittle" class="form-control input-lg" placeholder="Enter Search Tittle.." />
                <div id="tittleList">
                </div>
            </div>
            {{ csrf_field() }}
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


<script>
    $(document).ready(function(){
        $('#post_tittle').keyup(function(){
            var query = $(this).val();

            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('blogs.fetch') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#tittleList').fadeIn();
                               $('#tittleList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){
            $('#post_tittle').val($(this).text());
            $('#tittleList').fadeOut();
        });

    });
</script>