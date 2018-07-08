<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reply;

class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        //注入回复实体，方便toDatabase方法中的使用
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *每个通知类都有个 via() 方法，它决定了通知在哪个频道上发送。我们写上 database 数据库来作为通知频道。
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //开启通知的频道
        return ['database', 'mail'];
    }

    /**
     * @param $notifiable
     * @return array
     * 因为使用数据库通知频道，我们需要定义 toDatabase()。这个方法接收 $notifiable 实例参数并返回一个普通的 PHP 数组。
     * 这个返回的数组将被转成 JSON 格式并存储到通知数据表的 data 字段中。
     */
    public function toDatabase($notifiable)
    {
        $topic = $this->reply->topic;
        //link() 要求是数组
        $link =  $topic->link(['#reply' . $this->reply->id]);
        // 存入数据库里的数据
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }

    public function toMail($notifiable)
    {
        $url = $this->reply->topic->link(['#reply' . $this->reply->id]);
        return (new MailMessage)
            ->line('你的话题有新回复！')
            ->action('查看回复', $url)
            ->line('Thank you for using our application!')
            ->line('Thank you for using our application!')
        ->line('Thank you for using our application!');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMails($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}