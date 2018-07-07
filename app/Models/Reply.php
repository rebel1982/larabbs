<?php

namespace App\Models;

class Reply extends Model
{
    //设置允许修改的字段
    protected $fillable = [ 'content'];
    //一个回复属于一个话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    //一条回复属于一个作者所有
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
