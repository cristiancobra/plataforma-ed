<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $images = Image::whereIn('account_id', userAccounts())
                ->get();
//dd($images);
        return view('libraries/images/index', compact(
                        'images',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $types = $this->listTypes();
        $status = $this->listStatus();

        return view('libraries/images/create', compact(
                        'accounts',
                        'types',
                        'status',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $image = new Image();
        $image->fill($request->all());

        $path = $request->file('image')->store('users_images');
        $image->path = $path;
        $image->save();

        return view('libraries/images/show', compact(
                        'image',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image) {

        return view('libraries/images/show', compact(
                        'image',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image) {
        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();
        $types = $this->listTypes();
        $status = $this->listStatus();

        return view('libraries/images/edit', compact(
                        'accounts',
                        'image',
                        'types',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image) {
        $image->fill($request->all());
        if($request->file('image')) {
        $path = $request->file('image')->store('users_images');
        $image->path = $path;
        }
        $image->save();

        return view('libraries/images/show', compact(
                        'image',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image) {
        Storage::delete($image->path);
        $image->delete();
        return redirect()->action('Libraries\\ImageController@index');
    }

    // retorna os estágios das imagens
    public function listTypes() {
        return $stages = array(
            'produto',
            'logo',
            'imagem perfil',
        );
    }

    // retorna os estágios das imagens
    public function listStatus() {
        return $status = array(
            'disponível',
            'indisponível',
        );
    }

}
