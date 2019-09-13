@php
    $views=\App\Blog::orderBy('view_count','desc')->take(3)->get();
    $categories=\APP\Category::orderBy('title','asc')->get();

@endphp

<div class="col-md-4">

    <aside class="right-sidebar">
        <div class="search-widget">
            <form action="{{route('blogs.fetch')}}">
                @csrf
                <div class="input-group">
                <input type="text" class="form-control input-lg" name="post_tittle" placeholder="Search for...">
                <span class="input-group-btn">
                            <button class="btn btn-lg btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                          </span>
            </div><!-- /input-group -->
            </form>
            <div id="tittle_list"></div>
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
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endpush
<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript">
    $(document).ready(function () {
        $('#post_tittle').on('keyup',function() {
            var query = $(this).val();
            $.ajax({
                url:"{{ route('blogs.show') }}",
                type:"GET",
                data:{'post_tittle':query},
                success:function (data) {
                    $('#tittle_list').html(data);
                }
            })
        });

        $(document).on('click', 'li', function(){
            var value = $(this).text();
            $('#post_tittle').val(value);
            $('#tittle_list').html("");
        });
    });
</script>