<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 全てのメソッドが呼ばれる前に先に呼ばれるメソッド
        view()->composer('*', function($view){
            $query_tag = Request::query('tag');
            // もしクエリパラメータtagがあれば、
            if(!empty($query_tag)){
            // タグで絞り込み
            $memos = Memo::select('memos.*')
                ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                ->where('memo_tags.tag_id', '=', $query_tag)
                ->where('user_id', '=', Auth::id() )
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC') //ASCが小さい順、DESCが大きい順
                ->get();
            }else{
            // タグがなければ全て取得
            $memos = Memo::select('memos.*')
                ->where('user_id', '=', Auth::id() )
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC') //ASCが小さい順、DESCが大きい順
                ->get();
            }
            
            
            $tags = Tag::where('user_id', '=', Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            $view->with('memos', $memos)->with('tags', $tags); 
            // 第1引数はViewで使うときの命名、第2引数は渡したい変数or配列
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
