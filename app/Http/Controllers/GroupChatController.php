<?php

namespace App\Http\Controllers;

use App\GroupChat;
use App\GroupChatMembers;
use App\GroupChatMessage;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use View;

class GroupChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getGroupList(){
        $user=Auth::user();
        $group_list=User::find($user->id)->getGroupChats;
    }

    public function deleteGroupMessage(Request $request){
        $message=GroupChatMessage::find($request->id);
        $message->deleted=1;
        $message->save();
        return response()->json([
            "code"=>200
        ]);
    }

    public function deleteGroup(){
        
    }

    public function createGroup(Request $request)
    {
        $chat = new GroupChat();
        $chat->name = $request->name;
        $chat->admin = Auth::user()->id;
        $chat->save();
        
        foreach ($request->members as $member) {
            $grp_memeber = new GroupChatMembers();
            $grp_memeber->group_chat_id = $chat->id;
            $grp_memeber->user_id = $member;
            $grp_memeber->save();
        }

        $grp_memeber = new GroupChatMembers();
        $grp_memeber->group_chat_id = $chat->id;
        $grp_memeber->user_id = Auth::user()->id;
        $grp_memeber->save();

        $user=Auth::user();

        $welcome_message=new GroupChatMessage();
        $welcome_message->message="New Group Chat $request->name Created By $user->name.";
        $welcome_message->sender=Auth::user()->id;
        $welcome_message->grpchat_id=$chat->id;
        $welcome_message->save();

        $message_list=GroupChat::find($chat->id)->getMessages;
        $group=$chat;
        $can_send_message=true;

        $html = View::make('messages.group.chat', compact('user', 'group', 'message_list', 'can_send_message'))->render();

        return response()->json([
            "code"=>200,
            "html"=>$html,
            "name" => $request->name,
            "members" => $request->members,
        ]);
    }
}
