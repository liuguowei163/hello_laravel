<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct(){
        //除了 except 数组中指定的动作，其他的动作都必须登录以后才能操作：
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
        //只允许未登录的用户来操作
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    //用户列表页面
    public function index(){
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
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
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //编辑页面确认修改
    public function update(User $user,Request $request){
        $this->authorize('update', $user);
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
    //删除用户
    public function destroy(User $user){
        $user->delete();
        session()->flash('success', '成功删除用户');
        return back();
    }
}
