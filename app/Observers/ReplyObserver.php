<?php

namespace App\Observers;

use App\Models\Reply;

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
        $reply->topic->increment('reply_count', 1);
    }
    //删除成功后reply_count字段-1
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}