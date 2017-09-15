<?php
namespace  App\Admin\Controllers;


class HomeController extends Controller
{
    //首页
    public function index()
    {
        return view('admin.Home.index');
    }

}
