<div style="z-index:10000;overflow-y:hidden;">
    <div class="mb-3 pb-3">
        <label for="">
            Group Admin
        </label>
        <div>
            <a href="javascript:;" style="font-size:13px"
                class="badge ml-1 p-3 mr-1 mt-2 badge-success grpmember">{{$group->getAdmin->name}}</a>
        </div>

    </div>
    <div class="mb-3 pb-3" id="group-member-widget">
        <label for="">
            Group Members ({{$group->getMembers->count()}})
        </label>
        <div class="" id="group-member-list">
            @foreach ($group->getMembers as $member)
            @if ($member->id!=$group->admin)
            @if($group->getMembers->count()<=2) <a href="javascript:;" style="font-size:13px"
                class="disabled badge ml-1 p-3 mr-1 mt-2 badge-dark">{{$member->name}}</a><br>
                <span class="text-small text-danger">Couldn't Remove Any Members.<br>At Least 2 Members Should Be In a
                    Group.<br> Try Delete The Group.</span>
                @else
                <a onclick="deleteMember('{{$group->id}}','{{$member->id}}','{{$member->name}}')"
                    id="group-member-{{$member->id}}" href="javascript:;" style="font-size:13px"
                    class="badge ml-1 p-3 mr-1 mt-2 badge-dark">{{$member->name}}</a>

                @endif
                @endif
                @endforeach
        </div>
    </div>
    <label>Add New Members To The Chat</label>
    <input type="text" class="form-control modal-search" id="modal-search-group" onkeyup="searchUserListGroup()"
        onfocusout="hideList()" onfocus="showList()" placeholder="Search for names..">

    <div style="display:none" id="search-user-widget" class="user_list">
        <div id="search-user-list" style="overflow-x:hidden;height:25vh !important;">
            <table class="" id="modal-table-group">
                @foreach($user_list->get() as $f)
                @if (!$group->isMember($f->follower->id))
                <tr>
                    <td>
                        <a href="javascript:;" onclick="addNewMember({{ $f->follower->id }})">
                            <div style="display:inline-flex" class="image">
                                <img src="{{ $f->follower->getPhoto(50,50) }}" alt="{{ $f->follower->name }}"
                                    class="img-circle" />
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
    <div style="display:none;" class="mb-3 mt-3 pt-3 pb-1" id="group-member-widget-2">
        <label for="">
            New Members To Be Added
        </label>
        <div id="group-member-list-2">

        </div>
    </div>
</div>

<button class="mt-2 btn btn-success" id="add-new-member-grp-btn" style="display:none" disabled onclick="addMembersToGroup({{$group->id}});">Add New
    Members</button>