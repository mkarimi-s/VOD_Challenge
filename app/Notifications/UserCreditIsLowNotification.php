<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Log;

class UserCreditIsLowNotification extends Notification
{
    use Queueable;

    /**
     * UserCreditIsLowNotification constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::debug('mail channel', $notifiable);
        return (new MailMessage)
                    ->greeting(sprintf('Hi dear %s' , $notifiable->username))
                    ->line(
                        sprintf(
                            'As your credit is a bit low! 
                            we just want to inform that you have only %d in your conduit!',
                            $this->_balance
                        )
                    )
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for attending!');
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
            'notifiable' => $notifiable,
            'user_credit' => $notifiable->transactionsBalance->balance,
        ];
    }
}
