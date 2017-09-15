<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('register/index');
    }
    //注册行为
    public function register()
    {
        //验证
        $this->validate(request(),[
            'name'=>'required|min:3|unique:users,name',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:6|max:10|confirmed',
        ]);
        //逻辑
        $name=request('name');
        $email=request('email');
        $password=bcrypt(request('password'));//laravel自带的密码加密
        User::create(compact('name','email','password'));
        //渲染
        return redirect('/login');
    }
}
