<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Team;
use App\Models\User;

class TeamInvitationNotification extends Notification
{
    use Queueable;

    public $team;
    public $inviter;

    public function __construct(Team $team, User $inviter)
    {
        $this->team = $team;
        $this->inviter = $inviter;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("You've been invited by {$this->inviter->name} to join {$this->team->name}.")
                    ->action('Join Team', url('/teams'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'inviter_name' => $this->inviter->name,
            'message' => "You've been invited by {$this->inviter->name} to join {$this->team->name}."
        ];
    }
}