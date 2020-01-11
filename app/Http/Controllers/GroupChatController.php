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

    public function send(Request $request){
        $user=Auth::user();
        $chat_id=$request->id;
        $message=$request->message;
        $grp_message=new GroupChatMessage();
        $grp_message->sender=$user->id;
        $grp_message->message=$message;
        $grp_message->grpchat_id=$chat_id;
        $message=$grp_message;
        if ($grp_message->save()){
            $html = View::make('messages.group.single_message', compact('user', 'message'))->render();
            return response()->json([
                "code"=>200,
                "message_id"=>$grp_message->id,
                "html"=>$html,
            ]);
        }else{
            return response()->json([
                "code"=>400,
            ]);
        }
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

    public function deleteGroup(Request $request){
        $grp_messages=GroupChat::find($request->id)->getMessages;
        
        foreach ($grp_messages as $message) {
            GroupChatMessage::find($message->id)->delete();
        }
        $grp_members=GroupChatMembers::where('group_chat_id',$request->id)->get();
        
        foreach ($grp_members as $member) {
            GroupChatMembers::find($member->id)->delete();
        }

        GroupChat::find($request->id)->delete();

        return response()->json([
            'code'=>200,
            'id'=>$request->id,
            'message'=>"Group Chat Deleted",
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
