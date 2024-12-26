<?php
namespace App\Actions\App\User;

use App\Models\User;
use App\Notifications\NewPasswordNotification;
use Illuminate\Support\Str;

class GerarSenhaAleatoriaAction
{
    public function __invoke(User $user)
    {
        $password = Str::random(8);
        return tap($user->update(compact('password')), function ($result) use ($password, $user) {
            $result and $user->notifyNow(
                new NewPasswordNotification($password)
            );
        });
    }
}