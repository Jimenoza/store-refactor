<?php

namespace tiendaVirtual\Http\Controllers\Common;

use Illuminate\Http\Request;
use tiendaVirtual\Reply;

class ReplyController
{
    public static function getReplies($id){
        return Reply::where('calification_id',$id)->get();
    }
}
