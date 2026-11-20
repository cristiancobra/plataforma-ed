<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration original perdida do repositório (não estava versionada, mas já havia rodado em
 * produção/local). Recriada a partir do schema real da tabela `contacts_companies` (SHOW CREATE
 * TABLE). É uma tabela pivô distinta de `company_contact` (criada por outra migration que
 * continua no repositório com o mesmo timestamp) — ambas existem de fato no banco real.
 */
class CreateContactsCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('contacts_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id');
            $table->foreignId('company_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts_companies');
    }
}
