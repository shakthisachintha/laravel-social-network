@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">


            <div class="content-page-title">
                <i class="fa fa-commenting"></i> Direct Messages
            </div>


            <div class="new-message-button">
                <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#userListModal">
                    <i class="fa fa-commenting"></i> New Message
                </button>

                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#grpChatModal">
                    <i class="fa fa-comments"></i> Make New Group
                </button>
            </div>


            <div class="dm">


                <div class="friends-list">


                </div>

                <div class="chat">



                </div>

            </div>

            {{-- Chat Modal --}}
            <div class="modal fade userListModal" id="userListModal" tabindex="-1" role="dialog" aria-labelledby=""
                aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">New Message</h5>
                        </div>

                        <div class="user_list">
                            @if($user_list->count() == 0)
                            <div class="alert alert-danger" role="alert" style="margin: 10px;">There is no people!</div>
                            @else
                            <div class="form-group">
                                <input type="text" class="form-control modal-search" id="modal-search"
                                    onkeyup="searchUserList()" placeholder="Search for names..">
                            </div>
                            <table id="modal-table">
                                @foreach($user_list->get() as $f)
                                <tr>
                                    <td>
                                        <a href="javascript:;" onclick="showChat({{ $f->follower->id }})">
                                            <div class="image">
                                                <img src="{{ $f->follower->getPhoto(50, 50) }}"
                                                    alt="{{ $f->follower->name }}" class="img-circle" />
                                            </div>
                                            <div class="detail">
                                                <strong>{{ $f->follower->name }}</strong>
                                                <small>{{ '@'.$f->follower->username }}</small>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Chat Modal --}}

            {{-- Group Chat Modal --}}

            <div class="modal fade userListModal" id="grpChatModal" tabindex="-1" role="dialog" aria-labelledby=""
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button onclick="resetGroups();" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="lead modal-title">Create New Group Chat</h5>
                        </div>

                        <div class="p-5 modal-body">

                            <div style="z-index:10000;overflow-y:hidden;">
                                @if($user_list->count() == 0)
                                <div class="alert alert-danger" role="alert" style="margin: 10px;">There Is No People!
                                </div>
                                @else
                                <div>
                                    <div class="form-group">
                                        <label for="group-name">Group Name</label>
                                        <input onchange="setName(this.value);" id="group-name" class="form-control" type="text"
                                            placeholder="Ex. My Aweseome Group" name="">
                                    </div>
                                </div>
                                <label>Add Members To The Chat</label>
                                <input type="text" class="form-control modal-search" id="modal-search-group"
                                    onkeyup="searchUserListGroup()" onfocusout="hideList()" onfocus="showList()"
                                    placeholder="Search for names..">

                                <div style="display:none;" id="search-user-widget" class="user_list">
                                    <div id="search-user-list" style="overflow-x:hidden;height:25vh !important;">
                                        <table class="mx-auto justify-content-center nano" id="modal-table-group">
                                            @foreach($user_list->get() as $f)
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" onclick="addToGroup({{ $f->follower->id }})">
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
                                            @endforeach
                                        </table>
                                    </div>
                                    @endif
                                </div>
                                <div class="mt-3 mb-3 pt-3 pb-3 bg-dark" style="display:none"
                                    id="group-member-widget">
                                    <label for="">
                                        Added Members
                                    </label>
                                    <div id="group-member-list">

                                    </div>
                                </div>
                            </div>

                            <button class="mt-3 btn btn-success" id="create-grp-btn" disabled onclick="createGroup();">Create Group</button>
                        </div>
                        
                    </div>
                </div>
            </div>

            {{--End Group Chat Modal --}}

        </div>
    </div>
</div>



@endsection

@section('footer')
<script type="text/javascript">
    @if($show)
            var initial_dm = 1;
        @else
            var initial_dm = 0;
        @endif
</script>
<script src="{{ asset('js/dm.js') }}"></script>
<script src="{{ asset('js/grp.js') }}"></scrpit>
<script type="text/javascript">
    @if($show)
            $(function() {
                showChat({{ $id }});
            });
        @endif
</script>

    
    @if($user_list->count() != 0)
    <script>
        var followers=[
        @foreach($user_list->get() as $f)
         {
             "id":"{{$f->follower->id}}",
             "name":"{{$f->follower->name}}"
         },
        @endforeach
        ]
    </script>
    @endif    

@endsection