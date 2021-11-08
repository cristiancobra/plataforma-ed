<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Text extends Model {

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
    protected $hidden = [
    ];

    // RELACIONAMENTOS

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // MÉTODOS PÚBLICO

    public static function filterTexts(Request $request) {
        $texts = Text::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with(
                        'user.contact',
                        'user.image',
//                        'images',
                )
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        $texts->appends([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'department' => $request->department,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return $texts;
    }

    public static function returnDepartments() {
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

    public static function returnStatus() {
        return $status = array(
            'rascunho',
            'revisão',
            'aprovado',
            'indisponível',
        );
    }

    public static function returnTypes() {
        return $status = array(
            'biografia',
            'blog',
            'copy de venda',
            'desativado',
            'perguntas frequentes',
            'tutorial',
        );
    }

    public static function myValueOffer() {
        return Text::where('account_id', auth()->user()->account_id)
                        ->where('type', 'proposta de valor')
                        ->first();
    }

    public static function myAbout() {
        return Text::where('account_id', auth()->user()->account_id)
                        ->where('type', 'apresentação da empresa')
                        ->first();
    }

    public static function myStrengths() {
        return Text::where('account_id', auth()->user()->account_id)
                        ->where('type', 'força')
                        ->get();
    }

    /**
     * Se o valor for 1, exibe na landing page pública a Apresentação da empresa.
     * @param type $page
     * @return type
     */
    public static function selectedAbout($page) {
            return Text::where('account_id', $page->account_id)
                            ->where('type', 'apresentação da empresa')
                            ->first();
    }

    /**
     * Se o valor for 1, exibe na landing page pública a Proposta de Valor da empresa.
     * @param type $page
     * @return type
     */
    public static function selectedValueOffer($page) {
            return Text::where('account_id', $page->account_id)
                            ->where('type', 'proposta de valor')
                            ->first();
    }

    /**
     * * Se o valor for 1, exibe na landing page pública os pontos fortes
     * @param type $page
     * @return type
     */
    public static function selectedStrengths($page) {
            return Text::where('account_id', $page->account_id)
                            ->where('type', 'força')
                            ->get();
    }

    /**
     * * Recebe um texto com tags html e remove estas Tags e converte caracteres especiais 
     * @param type $page
     * @return type
     */
    public static function unformatText($text) {
        $text = strip_tags($text);
        
// Clean up things like &amp;
        $text = html_entity_decode($text);


        return $text;
    }

}
