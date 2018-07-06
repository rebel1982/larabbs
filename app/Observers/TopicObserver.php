<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
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
        //生成话题摘录，调用自定义函数make_excerpt
        $topic->excerpt = make_excerpt($topic->body);
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}