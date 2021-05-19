<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Image;
use Illuminate\Http\Request;

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

        return view('libraries/images/create', compact(
            'accounts',
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image) {
        //
    }

}
