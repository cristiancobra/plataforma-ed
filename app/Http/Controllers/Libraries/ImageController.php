<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $images = Image::filterModel($request);
        $types = Image::returnTypes();

        return view('libraries/images/index', compact(
                        'images',
                        'types',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $types = $this->listTypes();
        $status = $this->listStatus();

        return view('libraries/images/create', compact(
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
        $messages = [
            'unique' => ' * :attribute já cadastrado.',
            'required' => ' *obrigatório.',

        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:images',
                    'image' => 'required|image|max:50000',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $image = new Image();
            $image->fill($request->all());
            $image->account_id = auth()->user()->account_id;

            if ($request->image_name) {
                $image->name = "Imagem $image da tarefa $request->image_name";
                $image->task_id = $request->task_id;
            }
            $path = $request->file('image')->store('users_images');
            $image->path = $path;
            $image->save();

            if ($request->task_id) {
                return redirect()->back();
            } else {

                return view('libraries/images/show', compact(
                                'image',
                ));
            }
        }
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
        $types = $this->listTypes();
        $status = $this->listStatus();

        return view('libraries/images/edit', compact(
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
        if ($request->file('image')) {
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

// retorna os estágios das images
    public function listTypes() {
        return $stages = array(
            'produto',
            'logo',
            'imagem perfil',
            'marketing',
        );
    }

// retorna os estágios das images
    public function listStatus() {
        return $status = array(
            'disponível',
            'indisponível',
        );
    }

}
