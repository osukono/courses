<?php

namespace App\Mail\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    protected string $password;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $password
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.created')
            ->text('emails.users.created_plain')
            ->subject('You have been registered to Yummy Lingo Console')
            ->with(['password' => $this->password]);
    }
}
