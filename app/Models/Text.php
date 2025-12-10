<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Text extends Model
{

    protected $table = 'texts';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'name',
        'title',
        'text',
        'department',
        'type',
        'status',
    ];
    protected $hidden = [];

    // RELACIONAMENTOS

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'text_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICO

       public static function returnDepartments()
    {
        return $departments = array(
            'administrativo',
            'atendimento',
            'desenvolvimento',
            'financeiro',
            'marketing',
            'produção',
            'vendas',
        );
    }

    public static function returnStatus()
    {
        return $status = array(
            'rascunho',
            'revisão',
            'aprovada',
            'desativada',
        );
    }

    public static function returnTypes()
    {
        return $status = array(
            'biografia',
            'blog',
            'documento',
            'teste',
            'desativado',
            'perguntas frequentes',
            'tutorial',
        );
    }

    public static function myValueOffer()
    {
        return Text::where('account_id', auth()->user()->account_id)
            ->where('type', 'proposta de valor')
            ->first();
    }

    public static function myAbout()
    {
        return Text::where('account_id', auth()->user()->account_id)
            ->where('type', 'apresentação da empresa')
            ->first();
    }

    public static function myStrengths()
    {
        return Text::where('account_id', auth()->user()->account_id)
            ->where('type', 'força')
            ->get();
    }

    /**
     * Se o valor for 1, exibe na landing page pública a Apresentação da empresa.
     * @param type $page
     * @return type
     */
    public static function selectedAbout($page)
    {
        return Text::where('account_id', $page->account_id)
            ->where('type', 'apresentação da empresa')
            ->first();
    }

    /**
     * Se o valor for 1, exibe na landing page pública a Proposta de Valor da empresa.
     * @param type $page
     * @return type
     */
    public static function selectedValueOffer($page)
    {
        return Text::where('account_id', $page->account_id)
            ->where('type', 'proposta de valor')
            ->first();
    }

    /**
     * * Se o valor for 1, exibe na landing page pública os pontos fortes
     * @param type $page
     * @return type
     */
    public static function selectedStrengths($page)
    {
        return Text::where('account_id', $page->account_id)
            ->where('type', 'força')
            ->get();
    }

    /**
     * * Recebe um texto com tags html e remove estas Tags e converte caracteres especiais 
     * @param type $page
     * @return type
     */
    public static function unformatText($text)
    {
        $text = strip_tags($text);

        // Clean up things like &amp;
        $text = html_entity_decode($text);


        return $text;
    }
}
