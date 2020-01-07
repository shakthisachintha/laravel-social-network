<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $table='grpchats';

    public function getAdmin(){
        return $this->belongsTo('App\Models\User','admin','id');
    }
}
