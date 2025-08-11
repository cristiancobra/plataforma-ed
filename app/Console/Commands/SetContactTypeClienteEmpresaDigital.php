<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;

class SetContactTypeClienteEmpresaDigital extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact:clienteInNull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insere CLIENTE em contatos que são da Empresa Digital e type null';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contacts = Contact::where('account_id', '1')
                ->where('type', null)
                ->get();
        
        foreach($contacts as $contact) {
            $contact->type = 'cliente';
            $contact->save();
        }
    }
}
