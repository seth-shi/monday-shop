<?php

namespace App\Notifications;

use App\Models\CouponCode;
use App\Models\CouponTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CouponCodeNotification extends Notification
{
    private $template;
    private $code;

    public function __construct(CouponTemplate $template, $code)
    {
        $this->template = $template;
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'title' => $this->template->title . '兑换码',
            'start_date' => $this->template->start_date,
            'end_date' => $this->template->end_date,
            'code' => $this->code,
        ];
    }
}
