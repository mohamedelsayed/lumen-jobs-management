<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RegularUserJobCreated extends Notification
{
    use Queueable;

    /** @var Job */
    public $job;

    /**
     * @param Job $job
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification’s delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('Regular user created a job!')
        ->markdown('mails.regularUserJobCreated', ['job' => $this->job, 'user'=>$this->job->user]);
    }
}
