<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $table='grpchats';

    public function getAdmin(){
        return $this->belongsTo('App\Models\User','admin','id');
    }

    public function getMessages(){
        return $this->hasMany('App\GroupChatMessage','grpchat_id')->orderBy('created_at','DESC')->where('deleted',0)->limit(100);
    }

    public function getMembers(){
        return $this->belongsToMany('App\Models\User','grpchat_members');
    }

    public function isMember($id){
        $members=$this->getMembers;
        foreach ($members as $member) {
            if($id==$member->id){
                return true;
            };
        }
        return false;
    }


}
