<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
//        return $topic->user_id == $user->id;
        //代码复用
        //在User模型中定义isAuthorOf方法
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
//        return $topic->user_id == $user->id;
        return $user->isAuthorOf($topic);
    }
}
