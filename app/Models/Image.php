<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Image extends Model {

    protected $table = 'images';
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'contact_id',
        'name',
        'alt',
        'path',
        'type',
        'status',
        'status'
    ];

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public static function myBanners() {
        return Image::where('account_id', auth()->user()->account_id)
                        ->where('status', 'disponível')
                        ->where('type', 'marketing')
                        ->get();
    }

    //FUNÇÕES PÚBLICAS
    public static function filterModel(Request $request) {
        if ($request->filter == 'news') {
            $orderColumn = 'created_at';
            $orderDirection = 'DESC';
        } else {
            $orderColumn = 'name';
            $orderDirection = 'ASC';
        };

        $items = Image::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
//                    if ($request->company_id) {
//                        $query->whereHas('companies', function ($query) use ($request) {
//                            $query->where('company_id', $request->company_id);
//                        });
//                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
//                    if ($request->created_at) {
//                        $query->where('created_at', '>=', $request->created_at);
//                    }
//                    if ($request->page_id) {
//                        $query->whereHas('pages', function ($query) use ($request) {
//                            $query->where('page_id', $request->page_id);
//                        });
//                    }
//                    if ($request->status == '') {
//                        // busca todos
//                    } elseif ($request->status == 'fazendo') {
//                        $query->where('status', 'fazer');
//                        $query->whereHas('journeys');
//                    } elseif ($request->status) {
//                        $query->where('status', $request->status);
//                    }
                })
                ->with(
//                        'opportunity',
//                        'journeys',
                        'user.contact',
                        'contact',
//                        'user.image',
                )
                ->orderBy($orderColumn, $orderDirection)
                ->paginate(20);

        $items->appends([
            'name' => $request->name,
//            'company' => $request->company_id,
//            'type' => $request->type,
        ]);

        return $items;
    }
    
    /**
     * retorna os tipos de imagem
     * @return type
     */
    public static function returnTypes() {
        return [
            'produto',
            'logo',
            'imagem perfil',
            'marketing',
            'enviado por cliente',
        ];
    }
    
        
    /**
     * Update tIMAGE in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public static function updateProfilePicture(Request $request, User $user) {
                    $image = new Image();
            $image->fill($request->all());
            $image->account_id = auth()->user()->account_id;
            $image->user_id = $user->id;
                $image->name = "Foto de perfil " . $user->contact->name . " - " . date('d/m/Y - H:m');
            $path = $request->file('image')->store('users_images');
            $image->path = $path;
            $image->save();

        return $image;
    }

}
