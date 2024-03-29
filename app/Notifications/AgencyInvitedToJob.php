<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AgencyInvitedToJob extends Notification
{
    use Queueable;

    public $user;
    public $sender;
    public $job;
    public $message;
    public $agency;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( \App\User $user, \App\User $sender, \App\Job $job, \App\Agency $agency, $message)
    {
        $this->user = $user;
        $this->job = $job;
        $this->sender = $sender;
        $this->message = $message;
        $this->agency = $agency;

        \App\MailLog::create( [
            'to_user_id'   => $user->id,
            'from_user_id' => $sender->id,
            'job_id'       => $job->id,
            'type'         => 'job-invite'
        ] );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via( $notifiable )
    {
        return [ 'mail' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable )
    {
        return ( new SageMailMessage )
            ->subject( 'Your agency, ' . $this->agency->name . ' was invited to a job: ' . $this->job->title )
            ->level( 'success' )
            ->greeting( "Your agency was invited to  new job: " . $this->job->title . "," )
            ->line( "You were invited to apply for this job. Please either accept or decline this invitation as soon as possible.")
            ->line( "You can accept or reject the invitation from your agencies notification panel.")
            ->line("Message from client:")
            ->line( $this->message )
            ->action( 'View Job', url( '/job/' . $this->job->id ) );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray( $notifiable )
    {
        return [
            'user' => $this->user
        ];
    }
}
