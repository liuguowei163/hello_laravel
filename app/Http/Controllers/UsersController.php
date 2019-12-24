<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
    //注册页面的提交验证方法,验证通过，跳转到个人页面
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
    //编辑页面的展示
    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    //编辑页面确认修改
    public function update(User $user,Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data['name'] = $request->name;
        if($request['password']){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '个人资料更新成功!');
        // $user->update([
        //     'name' => $request->name,
        //     'password' => bcrypt($request->password)
        // ]);
        return redirect()->route('users.show', $user->id);

    }
}
