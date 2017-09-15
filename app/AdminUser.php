<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{   //重新token字段
    protected $rememberTokenName='';
    //注入字段权限
    protected $guarded=[];
    //1用户有哪些角色,定义关系 关联 取出数据
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class,'admin_role_user','user_id','role_id')
                    ->withPivot(['user_id','role_id']);
    }
    //2判断是否有某些角色
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }
    //3给用户分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }
    //4取消用户分配的角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
    //5用户是否拥有权限
    public function hasPermission($permission)
    {   //return 返回结果
     return   $this->isInRoles($permission->roles);
    }
}
