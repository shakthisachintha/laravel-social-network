<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GroupChatMessages extends Model
{
    protected $table="grpchat_messages";

    public function isDeleted(){
        $status=$this->deleted;
        return($status==0?false:true);
    }

    public function delete(){
        $this->deleted=1;
        $this->save();
    }

    public function seenBy($user_id=null){
        if($user_id!=null){
            if($this->seenby==null){
                $init='{"users":[]}';
                $this->seenby=$init;
                $this->save();
            }
            $users=json_decode($this->seenby,true);
            array_push($users['users'],array('id'=>$user_id,'time'=>Carbon::now()->toDateTimeString()));
            $this->seenby=json_encode($users);
            $this->save();
        }
        $users=json_decode($this->seenby);
        return $users;
    }
}
