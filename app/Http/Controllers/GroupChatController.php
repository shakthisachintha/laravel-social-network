<?php

namespace App\Http\Controllers;

use App\GroupChat;
use App\GroupChatMembers;
use Auth;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    //
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

        return response()->json([
            "name" => $request->name,
            "members" => $request->members,
        ]);
    }
}
