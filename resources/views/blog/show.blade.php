@extends('layouts.main')

@section('content')

            <div class="col-md-8">
                <article class="post-item post-detail">
                    <div class="post-item-image">
                        <form style=""  >
                            @csrf
                            <input type="hidden" name="_method" value="POST">
                            <input type="text" name="view_count" id="view_count" class="form-control" value="{{$blogs->view_count}}">
                        <a href="{{ route('blogs.view', $blogs->id) }}">
                            <img src="{{ URL::to('/') }}/image/{{$blogs->post_photo}}" alt="" style="width: 100%;height:30%;">
                        </a>
                        </form>
                    </div>

                    <div class="post-item-body">
                        <div class="padding-10">
                            <h1>{{$blogs->post_tittle}}</h1>

                            <div class="post-meta no-border">
                                <ul class="post-meta-group">
                                    <li><i class="fa fa-user"></i><a href="#">{{ @ $blogs->user->name}}</a></li>
                                    <li><i class="fa fa-clock-o"></i><time> {{ date('F d, Y',  strtotime($blogs->created_at)) }}</time></li>
                                    <li><i class="fa fa-folder"></i><a href="#">{{ @ $blogs->category->title}}</a></li>
                                    <li><i class="fa fa-tags"></i>
                                        @foreach($blogs->tags as $tag)
                                        <a href="{{route('tag',$tag->second_name)}}">{{$tag->name}}</a>,
                                            @endforeach
                                    </li>
                                    <li><i class="fa fa-comments"></i><a href="#post-comments">{{$blogs->commentsNumber('Comment')}}</a></li>
                                </ul>
                            </div>

                            <p>{!!$blogs->post_descripition!!}</p>
                        </div>
                    </div>
                </article>
                <article class="post-author padding-10">
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ route('blogs.view', $blogs->id) }}">
                                <img alt="Author 1" src="{{ URL::to('/') }}/image/{{ @ $blogs->user->user_photo}}" class="media-object" style="width: 100px;height:100px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">{{ @ $blogs->user->name}}</a></h4>
                            <div class="post-author-count">
                                <a href="#">
                                    <i class="fa fa-clone"></i>
                                    {{$blogs->user->blogs->count()}} posts
                                </a>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis ad aut sunt cum, mollitia excepturi neque sint magnam minus aliquam, voluptatem, labore quis praesentium eum quae dolorum temporibus consequuntur! Non.</p>
                        </div>
                    </div>
                </article>

                <article class="post-comments"id ="post-comments">
                    <h3><i class="fa fa-comments"></i> {{$blogs->commentsNumber('Comment')}}</h3>

                    <div class="comment-body padding-10">
                        <ul class="comments-list">
                          @foreach($blogs->comments as $comment)
                            <li class="comment-item">
                                <div class="comment-heading clearfix">
                                    <div class="comment-author-meta">
                                        <h4>{{$comment->user_name}}    <small>{{$comment->created_at->diffForHumans()}}</small></h4>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    {{$comment->comment}}
                                </div>
                            </li>
                      @endforeach
                        </ul>

                    </div>
                  @if($setting->comment ==1)
                    <div class="comment-footer padding-10">
                        <h3>Leave a comment</h3>
                        <form method="post" action="{{ route('blogs.comments',$blogs->id) }}">
                            @csrf
                            <div class="form-group required">
                                <label for="name">Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control">
                            </div>
                            <div class="form-group required">
                                <label for="email">Email</label>
                                <input type="text" name="user_email" id="user_email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="text" name="user_url" id="user_url" class="form-control">
                            </div>
                            <div class="form-group required">
                                <label for="comment">Comment</label>
                                <textarea name="comment" id="comment" rows="6" class="form-control"></textarea>
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                                </div>
                                <div class="pull-right">
                                    <p class="text-muted">
                                        <span class="required">*</span>
                                        <em>Indicates required fields</em>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
@endif
                </article>
            </div>

@endsection
<script src="http://code.jquery.com/jquery-1.11.0.min.js">

   let viewCount =document.getElementById('view_count').value;

    let viewCountPlusOne=parseInt('viewCount')+1;
    viewCountPlusOne =document.getElementById('view_count').value;
    let $formVar= $('form');
    $.ajax({
        url:$formVar.prop('{{route('blogs.update',[$blogs->id])}}'),
        method:"POST",
        data:$formVar.serialize()
    });


</script>
