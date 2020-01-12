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

    public function send(Request $request)
    {
        $user = Auth::user();
        $chat_id = $request->id;
        $message = $request->message;
        $grp_message = new GroupChatMessage();
        $grp_message->sender = $user->id;
        $grp_message->message = $message;
        $grp_message->grpchat_id = $chat_id;
        $message = $grp_message;
        if ($grp_message->save()) {
            GroupChatMessage::find($message->id)->seenBy($user->id);
            $html = View::make('messages.group.single_message', compact('user', 'message'))->render();
            return response()->json([
                "code" => 200,
                "message_id" => $grp_message->id,
                "html" => $html,
            ]);
        } else {
            return response()->json([
                "code" => 400,
            ]);
        }
    }

    public function removeMember(Request $request){
        $group_id=$request->grp_id;
        $member_id=$request->member_id;
        $query=GroupChatMembers::where('group_chat_id',$group_id)->where('user_id',$member_id)->first()->delete();
        if($query){
            return response()->json([
                'code'=>200,
            ]);
        }else{
            return response()->json([
                'code'=>400,
            ]);
        }
    }

    public function getChatList()
    {
        $user = Auth::user();
        $groups = User::find($user->id)->getGroupChats;
    }

    public function chat(Request $request)
    {
        $user = Auth::user();
        $group = GroupChat::find($request->id);
        $message_list = GroupChat::find($group->id)->getMessages;
        foreach ($message_list as $message) {
            if (!$message->isSeen($user->id)) {
                $message->seenBy($user->id);
            }
        }
        $can_send_message = true;
        $html = View::make('messages.group.chat', compact('user', 'group', 'message_list', 'can_send_message'))->render();
        return response()->json([
            "code" => 200,
            "html" => $html,
        ]);
    }

    public function newMessages(Request $request)
    {    
        $user=Auth::user();

        $group=GroupChat::find($request->id)->getMessages;

        $message_list=[];
        
        foreach ($group as $message) {
            if(!$message->isSeen($user->id)){
                array_push($message_list,$message);
                $message->seenBy($user->id);
            }
        }

        if(count($message_list)>0){
            $find=1;
            $html = View::make('messages.group.new_messages', compact('user', 'message_list'))->render();
            return response()->json([
                'code'=>200,
                'html'=>$html,
                'find'=>$find,
            ]);
        }else{
            $find=0;
            return response()->json([
                'code'=>200,
                'find'=>$find,
            ]);
        }
    }

    public function getGroupList()
    {
        $user = Auth::user();
        $group_list = User::find($user->id)->getGroupChats;
    }

    public function deleteGroupMessage(Request $request)
    {
        $message = GroupChatMessage::find($request->id);
        $message->deleted = 1;
        $message->save();
        return response()->json([
            "code" => 200,
        ]);
    }

    public function deleteGroup(Request $request)
    {
        $grp_messages = GroupChat::find($request->id)->getMessages;

        foreach ($grp_messages as $message) {
            GroupChatMessage::find($message->id)->delete();
        }
        $grp_members = GroupChatMembers::where('group_chat_id', $request->id)->get();

        foreach ($grp_members as $member) {
            GroupChatMembers::find($member->id)->delete();
        }

        GroupChat::find($request->id)->delete();

        return response()->json([
            'code' => 200,
            'id' => $request->id,
            'message' => "Group Chat Deleted",
        ]);

    }

    public function groupData(Request $request){
        $group=GroupChat::find($request->id);
        $user=Auth::user();
        $user_list = $user->messagePeopleList();
        $html=View::make('messages.group.group_details',compact('group','user','user_list'))->render();
        return response()->json([
            'code'=>200,
            'html'=>$html
        ]);
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

        $user = Auth::user();

        $welcome_message = new GroupChatMessage();
        $welcome_message->message = "New Group Chat $request->name Created By $user->name.";
        $welcome_message->sender = $user->id;
        $welcome_message->grpchat_id = $chat->id;
        $welcome_message->save();

        $msg = GroupChatMessage::find($welcome_message->id);
        $msg->seenBy($user->id);

        $message_list = GroupChat::find($chat->id)->getMessages;
        $group = $chat;
        $can_send_message = true;

        $html = View::make('messages.group.chat', compact('user', 'group', 'message_list', 'can_send_message'))->render();

        return response()->json([
            "code" => 200,
            "html" => $html,
            "name" => $request->name,
            "members" => $request->members,
        ]);
    }
}
