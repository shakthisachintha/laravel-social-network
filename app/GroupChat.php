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
        return $this->hasMany('App\GroupChatMessage','grpchat_id')->orderBy('created_at','DESC')->limit(100);
    }
}
