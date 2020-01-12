@if(count($user_list) == 0 && $group_list->count()==0)
   <div class="alert">No People!</div>
@else
    @php($i = 0)
    @foreach($user_list as $friend)
        <a href="javascript:;" id="chat-people-list-{{ $friend['user']->id }}" onclick="showChat({{ $friend['user']->id }})" class="friend @if($friend['user']->id == $active_user_id){{ 'active' }}@elseif($friend['new']){{ 'new-message' }}@endif">
            <div class="circle"></div>
            <div class="image">
                <img class="img-circle" src="{{ $friend['user']->getPhoto(70, 70) }}">
            </div>
            <div class="detail">
                <strong>{{ $friend['user']->name }}</strong>
                <span>{{ str_limit($friend['message']->message, 20) }}</span>
                <small>{{ $friend['message']->created_at->diffForHumans() }}</small>
            </div>
            @if($i == 0)
                <input type="hidden" name="people-list-first-id" value="{{ $friend['user']->id }}" />
            @endif
            <div class="clearfix"></div>
        </a>
        @php($i++)
    @endforeach
@endif

@if(count($group_list) == 0)

@else
    @php($i = 0)
    @foreach($group_list as $group)
        <a href="javascript:;" id="chat-people-list-{{ $group->id }}" onclick="showGroupChat({{ $group->id }})" class="friend">
            <div class="circle"></div>
            <div class="image">
                <img class="img-circle" style="width:70px;height:70px" src="{{ asset('/images/group_icon.png') }}">
            </div>
            <div class="detail">
               <strong>{{$group->name}}</strong>
                <span> {{ explode(" ",$group->getMessages[0]->getSender->name)[0]}}:{{str_limit($group->getMessages[0]->message, 20) }}</span>
                <small>{{ $group->getMessages[0]->created_at->diffForHumans() }}</small>
            </div>
            @if($i == 0)
                <input type="hidden" name="people-list-first-id" value="{{ $group->id }}" />
            @endif
            <div class="clearfix"></div>
        </a>
        @php($i++)
    @endforeach
@endif