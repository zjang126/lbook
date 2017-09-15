<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;
    protected  $fillable=[
        'name','email','password'
    ];

    //获取用户的文章列表
    public function posts()
    {
        return $this->hasMany(\App\Post::class,'user_id');
    }
    //关注用户的fans
    public function fans()
    {
        return $this->hasMany(\App\Fan::class,'star_id','id');//id可写可不写,laravel默认
    }
    //用户关注的fans
    public function stars()
    {
        return $this->hasMany(\App\Fan::class,'fan_id');
    }
    //当前用户关注某人
    public function doFan($uid)
    {
        $fan=new \App\Fan();
        $fan->star_id=$uid;
        return $this->stars()->save($fan);
    }
    //取消关注
    public function doUnfan($uid)
    {
        $fan=new \App\Fan();
        $fan->star_id=$uid;
        return $this->stars()->delete($fan);
    }
    //当前用户是否已被关注
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id',$uid)->count();
    }
    //当前用户是否关注了uid
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id',$uid)->count();
    }
    //用户收到的通知
    public function notices()
    {
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')
                    ->withPivot(['user_id', 'notice_id']);
    }
    //给用户增加的通知
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }
}
