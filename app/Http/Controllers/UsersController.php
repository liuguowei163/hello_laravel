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

    public function show(User $user){
        echo '用户展示';
        // return view('users.show', compact('user'));
    }
}
