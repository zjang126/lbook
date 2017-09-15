<?php
namespace  App\Admin\Controllers;



use App\AdminUser;

class RoleController extends  Controller
{
    //角色列表
    public function index()
    {
        $roles=\App\AdminRole::paginate(10);
        return view('/admin/role/index',compact('roles'));
    }
    //创建角色页面
    public function create()
    {
        return view('/admin/role/add');
    }
    //创建角色行为
    public function store()
    {   //验证
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required',
        ]);
        //逻辑
        \App\AdminRole::create(request(['name','descriptioon']));
        //渲染
        return redirect('/admin/roles');
    }
    //角色与权限的关系页面
    public function permission(\App\AdminRole $role)
    {
        //获取所有权限
        $permissions=\App\AdminPermission::all();
        //获取当前角色权限
        $myPermissions=$role->permissions;

        return view('/admin/role/permission',compact('permissions','myPermissions','role'));
    }
    //存储角色权限行为
    public function storePermission(\App\AdminRole $role)
    {
        $this->validate(request(),[
            'permissions'=>'required|array'
        ]);

        $permissions=\App\AdminPermission::findMany(request('permissions'));
        $myPermissions=$role->permissions;

        //对已有权限
        $addPermissions=$permissions->diff($myPermissions);
        foreach($addPermissions as $permission){
            $role->grantPermission($permission);
        }

        $deletePermissions=$myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission){
            $role->deletePermission($permission);
        }
        return back();

    }
}