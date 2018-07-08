<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    //过滤数据
    public function creating(Reply $reply)
    {
        //config/purifier.php (过滤)  user_topic_body
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }
    //回复成功后reply_count字段+1
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        //通知作者话题被回复了
        //调用User模型里面的notify()方法将用户表notification_count字段+1
        $topic->user->notify(new TopicReplied($reply));

    }
    //删除成功后reply_count字段-1
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}