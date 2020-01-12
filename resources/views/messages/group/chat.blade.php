<input type="hidden" name="chat_friend_id" value="{{$group->id}}">
<div class="chat-info">
    <div class="user-profile">
        <img class="img-circle"
            src="http://localhost:8000/resizer.php?&amp;w=50&amp;h=50&amp;zc=1&amp;src=images/profile-picture.png">
        <div class="detail">
            <strong>{{$group->name}}</strong>
            <a href="javascript:;" onclick="groupDetails({{$group->id}});">Group Details</a>
        </div>
    </div>
    <a class="btn btn-default btn-xs btn-remove" onclick="deleteGroupChat({{$group->id}})" data-toggle="tooltip" data-placement="bottom"
        title="Delete Chat">
        <i class="fa fa-times"></i>
    </a>
    <div class="clearfix"></div>
</div>

<div class="message-list">
    @php($first_message_id = 0)
    @if($message_list->count() == 0)
    <div class="alert alert-info">
        No messages
    </div>
    @else
    @php($i=0)
    @foreach($message_list->reverse() as $message)

    @include('messages.group.single_message')

    @if($i == 0)
    @php($first_message_id = $message->id)
    @endif
    @php($i++)
    @endforeach
    @endif
    <div class="first_message_div">
        <input type="hidden" name="first_message_id" value="{{ $first_message_id }}">
    </div>
</div>

<div class="message-write">
    <form id="form-message-write">
        <input type="hidden" name="chat_id" value="{{$group->id}}">
        <textarea class="form-control" rows="1" placeholder="Your message.." onkeyup="sendGroupMessage(event)"
            spellcheck="false"></textarea>
    </form>
</div>