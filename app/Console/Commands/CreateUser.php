<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nome = $this->ask('Digite seu nome: ');
        if(!$nome) return $this->error('Vazio');
        $email = $this->ask('Digite seu email: ');
        if(!$email) return $this->error('Vazio');
        $password = $this->secret('Digite uma senha: ');
        if(!$password) return $this->error('Vazio!');
        if(str($password)->length() < 7) return $this->error('Senha precisa ter no mínimo 8 caracteres.');
        $user = User::create([
            'name' => $nome,
            'password' => Hash::make($password),
            'email' => $email
        ]);
        $this->info('Cadastrado com sucesso!');
    }
}
