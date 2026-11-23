<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    // SLUG / URL AMIGÁVEL

    /**
     * O slug acompanha o nome do documento: é gerado ao criar e refeito
     * quando o nome muda, sempre único dentro da conta.
     */
    protected static function booted()
    {
        static::saving(function (Text $text) {
            if (empty($text->slug) || $text->isDirty('name')) {
                $text->slug = static::uniqueSlug($text->name, $text->account_id, $text->id);
            }
        });
    }

    public static function uniqueSlug($name, $accountId, $ignoreId = null)
    {
        $base = Str::limit(Str::slug($name), 180, '') ?: 'documento';
        $slug = $base;
        $i = 2;

        while (static::where('account_id', $accountId)
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function getRouteKey()
    {
        return $this->slug ?: $this->id;
    }

    /**
     * Resolve pelo slug dentro da conta do usuário; IDs numéricos continuam
     * funcionando para os links antigos.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $query = static::where('account_id', auth()->user()?->account_id);

        return (clone $query)->where('slug', $value)->first()
            ?? (ctype_digit((string) $value) ? $query->where('id', $value)->first() : null)
            ?? abort(404);
    }

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
