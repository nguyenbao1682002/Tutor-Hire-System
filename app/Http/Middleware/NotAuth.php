<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if(auth()->user()->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }else if(auth()->user()->role == 'gia_su'){
                return redirect()->route('web.giasu.show', auth()->user()->id)->withErrors(['error' => "Bạn không được phép truy cập trang này khi đã đăng nhập!"]);
            }else if(auth()->user()->role == 'phu_huynh'){
                return redirect()->route('web.phuhuynh.show')->withErrors(['error' => "Bạn không được phép truy cập trang này khi đã đăng nhập!"]);
            }
        }
        return $next($request);
    }
}
