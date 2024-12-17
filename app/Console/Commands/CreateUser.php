<?php

namespace App\Console\Commands;

use App\Enums\TipoConta;
use App\Models\Conta;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        if (!$nome)
            return $this->error('Vazio');
        $email = $this->ask('Digite seu email: ');
        if (!$email)
            return $this->error('Vazio');
        $password = $this->secret('Digite uma senha: ');
        if (!$password)
            return $this->error('Vazio!');
        if (str($password)->length() < 7)
            return $this->error('Senha precisa ter no mínimo 8 caracteres.');

        $conta = $this->choice('Qual papel no sistema?', array_map(fn($item) => $item->name, TipoConta::cases()));
        DB::transaction(function () use($nome, $password, $email, $conta) {
            $user = User::create([
                'name' => $nome,
                'password' => Hash::make($password),
                'email' => $email
            ]);
            Conta::create([
                'type' => $conta,
                'user_id' => $user->id
            ]);
            $user->assignRole($conta);
            $this->info('Cadastrado com sucesso!');
        });
    }
}
