<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

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
            $memos = Memo::select('memos.*')
                ->where('user_id', '=', Auth::id() )
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC') //ASCが小さい順、DESCが大きい順
                ->get();

            $view->with('memos', $memos); // 第1引数はViewで使うときの命名、第2引数は渡したい変数or配列
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
