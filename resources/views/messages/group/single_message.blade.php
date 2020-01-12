<div class="message @if($message->sender == $user->id){{ 'message-right' }}@endif" id="chat-message-{{ $message->id }}">
    @if ($message->sender != $user->id)
    <em>
        {{$message->getSender->name}}
    </em>
    @endif
    
    <div class="text">
        {{ $message->message}}
    </div>
    @if($message->sender == $user->id)<a href="javascript:;" class="delete" onclick="deleteGroupChatMessage({{ $message->id }})">Delete</a>@endif
    
    <small>{{ $message->created_at->format('H:i') }}</small>
</div>
<div class="clearfix"></div>