<div style="border-radius:0.5rem;background:beige ;width:100% !important" class="panel-default round post-comment" id="post-comment-{{ $comment->id }}">
    <div class="panel-body">
        <div class="pull-left">
            <a href="{{ url('/'.$comment->user->username) }}">
                <img class="media-object img-circle comment-profile-photo" src="{{ $comment->user->getPhoto(60,60) }}">
            </a>
        </div>
        <div class="pull-left comment-info">
            <a style="color:cornflowerblue !important" href="{{ url('/'.$comment->user->username) }}" class="name">{{ $comment->user->name }}</a>
            
            {{-- <a href="{{ url('/'.$comment->user->username) }}" class="username">{{ '@'.$comment->user->username }}</a> --}}
            
            <span style="display:block" class="date mt-1">{{ $comment->created_at->diffForHumans() }}</span>
            
            <div class="clearfix"></div>
            <p class="mt-2" style="font-size:1.5rem;font-weight:400">
                {{ $comment->comment }}
            </p>
        </div>
        <div class="pull-right comment-info">
            @if($post->user_id == Auth::id() || $comment->comment_user_id == Auth::id())
            <a href="javascript:;" class="remove" onclick="removeComment({{ $comment->id }}, {{ $post->id }})"><i class="fa fa-times"></i></a>
        @endif
        </div>
        <br>
        
    </div>
</div>

<div class="clearfix"></div>

<hr />