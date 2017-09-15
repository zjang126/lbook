<?php

namespace App;

use App\Model;

class Comment extends Model
{
    //关联文章评论
    public function post()
    {
        return $this->belongsTo('App\post');
    }
    //评论所属用户
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
