<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreImageRequest;
use App\Models\User;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $images = Image::filterModel($request);
        $types = Image::returnTypes();
        $trashStatus = request()->trash;

        return view('libraries/images/index', compact(
            'images',
            'types',
            'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function store(StoreImageRequest $request)
    {
        $image = new Image();
        $image->fill($request->all());
        $image->account_id = auth()->user()->account_id;
        $image->user_id = auth()->user()->id;

        if ($request->image_name) {
            $image->name = "Imagem $image da tarefa $request->image_name";
            $image->task_id = $request->task_id;
        }
        $path = $request->file('image')->store('public/customers_images');
        $image->path = str_replace('public/', '', $path);
        $image->save();

        if ($request->task_id) {
            return redirect()->back();
        } else {
            return view('libraries/images/show', compact('image'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        $status = $image->status;
        $priority = $image->priority;

        return view('libraries/images/show', compact(
            'image',
            'status',
            'priority',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        $types = $this->listTypes();
        $status = $this->listStatus();
        $users = User::myUsers();

        return view('libraries/images/edit', compact(
            'image',
            'types',
            'status',
            'users',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->fill($request->except('image'));

        if ($request->hasFile('image')) {
            // Remove a imagem antiga, se necessário
            if ($image->path && \Storage::exists('public/' . $image->path)) {
                \Storage::delete('public/' . $image->path);
            }

            // Salva a nova imagem no diretório 'public/customers_images'
            $path = $request->file('image')->store('public/customers_images');
            $image->path = str_replace('public/', '', $path); // Remove o prefixo 'public/' para consistência
        }

        // dd($image);
        // if ($request->file('image')) {
        //     $path = $request->file('image')->store('customers_images');
        //     $image->path = $path;
        // }
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
    public function destroy(Image $image)
    {
        if ($image->path && Storage::exists('public/' . $image->path)) {
            Storage::delete('public/' . $image->path);
        }

        $image->delete();

        return redirect()->route('image.index')->with('success', 'Imagem removida com sucesso!');
    }

    /**
     * Move the specified resource to trash.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function sendToTrash(Image $image)
    {
        $image->trash = 1;
        $image->save();

        return redirect()->route('image.index')->with('success', 'Imagem movida para a lixeira com sucesso!');
    }

        /**
     * Restore the specified resource from trash.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function restoreFromTrash(Image $image)
    {
        $image->trash = 0;
        $image->save();
    
        return redirect()->back()->with('success', 'Imagem restaurada com sucesso!');
    }

    // retorna os estágios das images
    public function listTypes()
    {
        return $stages = array(
            'produto',
            'logo',
            'imagem perfil',
            'marketing',
        );
    }

    // retorna os estágios das images
    public function listStatus()
    {
        return $status = array(
            'disponível',
            'indisponível',
        );
    }
}
