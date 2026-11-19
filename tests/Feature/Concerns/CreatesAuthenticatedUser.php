<?php

namespace Tests\Feature\Concerns;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesAuthenticatedUser
{
    protected function loginAsAccountOwner(): User
    {
        $account = Account::create([
            'name' => 'Conta de Teste',
            'city' => 'Cidade Teste',
            'state' => 'TS',
            'country' => 'Brasil',
            'status' => 'ativo',
            'due_date' => now()->addYear(),
        ]);

        $contact = Contact::create([
            'account_id' => $account->id,
            'name' => 'Dono de Teste',
            'first_name' => 'Dono',
            'status' => 'ativo',
        ]);

        // account_id não está em $fillable no model User, então precisa ser setado via
        // atribuição direta antes do único save() (User::create() já faria o INSERT sem ele).
        $user = new User([
            'contact_id' => $contact->id,
            'perfil' => 'dono',
            'email' => 'smoke-dono@example.com',
            'password' => Hash::make('password'),
            'default_password' => 'password',
        ]);
        $user->account_id = $account->id;
        $user->save();

        $this->actingAs($user);

        return $user;
    }
}
