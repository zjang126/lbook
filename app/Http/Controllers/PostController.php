<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //列表页
    public function index()
    {
        $posts=POST::orderBy('created_at','desc')->withCount(['comments','zans'])->with('user')->paginate(6);
        //$posts->load('user'); //优化
        return view('post/index',compact('posts'));
    }
    //详情页
    public function show(Post $post)
    {//预加载 ,遵循mvc模式,评论
        $post->load('comments');
        return view('post/show',compact('post'));
    }
    //创建页面
    public function create()
    {
        return view('post/create');
    }
    //创建逻辑
    public function store()
    {
        //验证操作
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
        //逻辑
        $user_id=Auth::id();//用户权限操作
        $params=array_merge(request(['title','content']),compact('user_id'));
        Post::create($params);
        //渲染
        return redirect('/posts');
    }
    //修改页面
    public function edit(Post $post)
    {
        $this->authorize('update',$post);
        return view('post/edit',compact('post'));
    }
    //修改逻辑
    public function update(Post $post)
    {
        //验证操作
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
        //TODO:用户的权限验证
        $this->authorize('update',$post);
        //逻辑
        $post->title=request('title');
        $post->content=request('content');
        $post->save();
        //渲染
        return redirect("/posts/{$post->id}");
    }
    //删除页面
    public function delete(Post $post)
    {   //TODO:用户的权限验证
        $this->authorize('delete',$post);
        $post->delete();
        return redirect('/posts');
    }
    //提交评论
    public function comment(Post $post)
    {
        //验证
$this->validate(request(),[
    'content'=>'required|min:3'
]);
        //逻辑 传递的是一个对象
        $comment=new Comment();
        $comment->user_id=Auth::id();
        $comment->content=request('content');
       $post->comments()->save($comment);
        //渲染
        return back();
    }
    //点like  
    public function zan(Post $post)
    {
        $param=[
            'user_id'=>Auth::id(),
            'post_id'=>$post->id,
        ];
      Zan::firstOrCreate($param); //firstOrCreate 有就查找,没有就创建 只可以点一次like
        return back();
    }
    //取like
    public function unzan(Post $post)
    {
        $post->zan(Auth::id())->delete();
        return back();
    }
    //搜索结果页
    public function search()
    {
        //验证
        $this->validate(request(),[
           'query'=>'required'
        ]);
        //逻辑
        $query=request('query');
        $posts=\App\Post::search($query)->paginate(1);
        //渲染
        return view('post/search',compact('posts','query'));
    }

}
