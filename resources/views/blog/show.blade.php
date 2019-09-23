@extends('layouts.main')
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@section('content')

            <div class="col-md-8">
                <article class="post-item post-detail">
                    <div class="post-item-image">
                        <form style=""  >
                            @csrf
                            <input type="hidden" name="_method" value="POST">
                        
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
                                @if($comment->replies->count() > 0)
                            <li class="comment-item">
                                <div class="comment-heading clearfix">
                                    <div class="comment-author-meta">
                                        <h4>{{$comment->user_name}}    <small>{{$comment->created_at->diffForHumans()}}</small> </h4>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    {{$comment->comment}}
                                    <button type="button" name="reply" id="reply" class=" reply btn btn-success btn-sm">Add Reply</button>
                                </div>
                                        <ul class="comments-list-children">
                                            @foreach($comment->replies as $subcomment)
                                            <li class="comment-item">
                                                <div class="comment-heading clearfix">
                                                    <div class="comment-author-meta">
                                                        <h4>{{$subcomment->user_name}} <small>{{$subcomment->created_at->diffForHumans()}}</small></h4>
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    {{$subcomment->comment}}
                                                    <button type="button" name="reply" id="reply" class=" reply btn btn-success btn-sm">Add Reply</button>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                @else
                                    <li class="comment-item">
                                        <div class="comment-heading clearfix">
                                            <div class="comment-author-meta">
                                                <h4>{{$comment->user_name}}    <small>{{$comment->created_at->diffForHumans()}}</small></h4>
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            {{$comment->comment}}
                                            <button type="button" name="reply" id="reply" class=" reply btn btn-success btn-sm">Add Reply</button>
                                        </div>
                                    </li>
                                @endif

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
                            <input type="hidden" name="parent_id" id="parent_id">
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

                <div id="formModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Comment Reply</h4>
                            </div>
                            <div class="modal-body">
                                <span id="form_result"></span>
                                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-4" > Name : </label>
                                        <div class="col-md-8">
                                            <input type="text" name="user_name"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Email : </label>
                                        <div class="col-md-8">
                                            <input type="text" name="user_email"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Website : </label>
                                        <div class="col-md-8">
                                            <input type="text" name="user_url"   class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Reply : </label>
                                        <div class="col-md-8">
                                            <input type="text" name="comment"   class="form-control" />
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="parent_id"  value="{{ @ $comment->id}}"/>
                                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>

                $(document).ready(function(){


                    $(document).on('click', '.reply', function(){
                        $('.modal-title').text("Add Reply");
                        $('#action_button').val("Add");
                        $('#formModal').modal('show');
                    });

                    $('#sample_form').on('submit', function(event){
                        event.preventDefault();

                            $.ajax({
                                url:"{{ route('blogs.comments',$blogs->id) }}",
                                method:"POST",
                                data: new FormData(this),
                                contentType: false,
                                cache:false,
                                processData: false,
                                dataType:"json",
                                success:function(data)
                                {
                                    var html = '';
                                    if(data.errors)
                                    {
                                        html = '<div class="alert alert-danger">';
                                        for(var count = 0; count < data.errors.length; count++)
                                        {
                                            html += '<p>' + data.errors[count] + '</p>';
                                        }
                                        html += '</div>';
                                    }
                                    if(data.success)
                                    {
                                        html = '<div class="alert alert-success">' + data.success + '</div>';
                                        $('#sample_form')[0].reset();
                                        $('#formModal').modal('hide');
                                    }
                                    $('#form_result').html(html);
                                }
                            })



                    });


                });
            </script>

@endsection


