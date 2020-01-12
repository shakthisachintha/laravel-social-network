<div style="z-index:10000;overflow-y:hidden;">
    <div class="mb-3 pb-3">
        <label for="">
            Group Admin
        </label>
        <div>
            <a href="javascript:;" style="font-size:13px" class="badge ml-1 p-3 mr-1 mt-2 badge-success grpmember">{{$group->getAdmin->name}}</a>
        </div>

    </div>                                
    <div class="mb-3 pb-3" id="group-member-widget">
        <label for="">
            Group Members
        </label>
        <div class="added-grp-members" id="group-member-list">
            @foreach ($group->getMembers as $member)
            @if ($member->id!=$group->admin)
            <a onclick="deleteMember('{{$group->id}}','{{$member->id}}','{{$member->name}}')" id="{{$member->name}}-{{$member->id}}" href="javascript:;" style="font-size:13px" class="badge ml-1 p-3 mr-1 mt-2 badge-dark grpmember">{{$member->name}}</a>
            @endif
            @endforeach
        </div>
    </div>
    <label>Add New Members To The Chat</label>
    <input type="text" class="form-control modal-search" id="modal-search-group"
        onkeyup="searchUserListGroup()" onfocusout="hideList()" onfocus="showList()"
        placeholder="Search for names..">

    <div id="search-user-widget" class="user_list">
        <div id="search-user-list" style="overflow-x:hidden;height:25vh !important;">
            <table class="" id="modal-table-group">
                @foreach($user_list->get() as $f)
                @if (!$group->isMember($f->follower->id))
                <tr>
                    <td>
                        <a href="javascript:;" onclick="addNewMember({{ $f->follower->id }})">
                            <div style="display:inline-flex" class="image">
                                <img src="{{ $f->follower->getPhoto(50,50) }}"
                                    alt="{{ $f->follower->name }}" class="img-circle" />
                            </div>
                            <div style="display:inline-block" class="detail">
                                <strong>{{ $f->follower->name }}</strong>
                                <small>{{ '@'.$f->follower->username }}</small>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </td>
                </tr>    
                @endif
                
                @endforeach
            </table>
        </div>
    
    </div>
    
</div>

<button class="mt-3 btn btn-success" id="create-grp-btn" disabled
    onclick="addMembersToGroup(grp_id);">Add New Members</button>