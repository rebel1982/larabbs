<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //个人展示中心
    public function show(User $user)
    {
    	return view('users.show',compact('user'));
    }
    //个人编辑中心
    public function edit(User $user)
    {
    	return view('users.edit',compact('user'));
    }
    //更新个人资料
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
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
