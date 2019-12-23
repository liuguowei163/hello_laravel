<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //用户注册页面的渲染
    public function create(){
        return view('users.create');
    }

    //展示个人页面
    public function show(User $user){
        return view('users.show', compact('user'));
    }
    //注册页面的提交验证方法
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
