<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    //个人展示中心
    public function show(User $user)
    {   //查看自己信息
//        $this->authorize('view', $user);
    	return view('users.show',compact('user'));
    }
    //个人编辑中心
    public function edit(User $user)
    {   
        //编辑自己信息
        $this->authorize('update', $user);
    	
        return view('users.edit',compact('user'));
    }
    //更新个人资料
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        //更新自己信息
        $this->authorize('update', $user);

        $data = $request->all();
        // 第一种方法  $file = $request->file('avatar');
        // 第二种方法  $request->avatar;
        if ($request->avatar) {
            //$result = $uploader->save($request->avatar, 'avatars', $user->id);
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }


}
