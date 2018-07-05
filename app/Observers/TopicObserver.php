<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    /**
     * @param Topic $topic
     * make_excerpt 是我们自定义的辅助方法，我们需要在 helpers.php添加
     */
    public function saving(Topic $topic)
    {
        //过滤数据
        $topic->body = clean($topic->body, 'user_topic_body');
        //SEO
        $topic->excerpt = make_excerpt($topic->body);
    }
}