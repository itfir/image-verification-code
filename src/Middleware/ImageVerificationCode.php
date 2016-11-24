<?php

namespace Fir\ImageVerificationCode\Middleware;

use Closure;
class ImageVerificationCode{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if($request->exists('ImageVerificationCode')){
            $ImageVerificationCode = session()->pull('ImageVerificationCode');
            if(!empty($ImageVerificationCode)){
                if(strcasecmp($request->get('ImageVerificationCode'), $ImageVerificationCode) != 0){
                    return redirect()->back()->withInput()->with(['ImageVerificationCodeError' => '验证码错误！']);
                }
            }
        }
        return $next($request);;
    }
}
