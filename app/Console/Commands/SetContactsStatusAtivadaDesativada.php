<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;

class SetContactsStatusAtivadaDesativada extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a situação (status) de CONTATO para ativada ou desativda';

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
$contacts = Contact::all();

        foreach ($contacts as $contact) {
            switch ($contact->status) {
                case 'ativo';
                    $contact->status = 'ativada';
                    break;
                default;
                    $contact->status = 'ativada';
                    break;
            }
            $contact->save();
        }
    }

}
