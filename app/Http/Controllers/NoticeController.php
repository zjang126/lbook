<?php

namespace App\Http\Controllers;

class NoticeController extends Controller
{
    /*
     * 消息页面
     */
    public function index()
    {
        // 获取我收到的消息 获取当前用户
        $user = \Auth::user();
        $notices = $user->notices;
        return view("notice/index", compact('notices'));
    }
}
