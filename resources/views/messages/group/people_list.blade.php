@if(count($group_list) == 0)
   <div class="alert">No People!</div>
@else
    @php($i = 0)
    @foreach($group_list as $group)
        <a href="javascript:;" id="chat-people-list-{{ $group->id }}" onclick="showGroupChat({{ $group->id }})" class="friend">
            <div class="circle"></div>
            <div class="image">
                <img class="img-circle" src="{{ public_path('/images/group_icon.png') }}">
            </div>
            <div class="detail">
               <strong>{{$group->name}}</strong>
                <span> {{ explode(" ",$group->getMessages[0]->getSender->name)[0]:str_limit($group->getMessages[0]->message, 20) }}</span>
                <small>{{ $last_message->created_at->diffForHumans() }}</small>
            </div>
            @if($i == 0)
                <input type="hidden" name="people-list-first-id" value="{{ $group->id }}" />
            @endif
            <div class="clearfix"></div>
        </a>
        @php($i++)
    @endforeach
@endif