<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class SessionsController extends Controller
{
    public function __construct(){
        //只允许未登录的用户来操作
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    //显示登陆页面
    public function create(){
        return view('sessions.create');
    }
    //登陆提交验证方法
    public function store(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials, $request->has('remember'))){
            if(Auth::user()->activated){
                //登陆成功操作
                session()->flash('success', '欢迎回来');
                $fallback = route('users.show', [Auth::user()]);
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

        }else{
            //登陆失败操作
            session()->flash('danger', '很抱歉，邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }
    //退出登录
    public function destroy(){
        Auth::logout();
        session()->flash('success', '您已经成功退出');
        return redirect('login');
    }
}
