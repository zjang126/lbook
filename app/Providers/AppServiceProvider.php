<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //自动添加时修改默认varchar默认长度
        Schema::defaultStringLength(191);
        //视图合成器
        \View::composer('layout.sidebar',function($view){

            $topics=\App\Topic::all();
            $view->with('topics',$topics);
        });
        \DB::listen(function($query){
            $sql=$query->sql;
            $bindings=$query->bindings;
            $time=$query->time;
            if($time>2000){
                \Log::debug(var_export(compact('sql','bindings','time'),true));
            };

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
