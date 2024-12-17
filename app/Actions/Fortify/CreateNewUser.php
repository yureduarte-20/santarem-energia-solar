<?php

namespace App\Actions\Fortify;

use App\Actions\App\Mail\NotifyNewUserAction;
use App\Enums\TipoConta;
use App\Models\Conta;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'type' => 'required|in:'.join(',', TipoConta::cases_names()),
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return tap(User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]), function ($user) use ($input) {
            $action = new NotifyNewUserAction;
            Conta::create([
                'user_id' => $user->id,
                'type' => $input['type']
            ]);
            $user->assignRole($input['type']);
            $action($user->email, $input['password']);
        });
    }
}
