<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __contruct(){
        $this->middleware('auth');
    }
    //创建并生成微博
    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '创建成功');
        return redirect()->back();
    }
    //删除微博
    public function destroy(Status $status){
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '刪除成功');
        return redirect()->back();
    }

}
