<?php

namespace App\Actions\App\Mail;

use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class NotifyNewUserAction
{

    public function __invoke(string $email, string $password)
    {
        Validator::make(compact('email', 'password'), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
        Notification::route('mail', $email)->
            notify(new NewUserNotification($email, $password));
    }
}