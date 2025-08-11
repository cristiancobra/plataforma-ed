<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Journey;
use App\Models\Socialmedia;

class SocialmediaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $socialmedias = Socialmedia::where('account_id', auth()->user()->account_id)
                ->with("account")
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $socialmedias->total();

        return view('marketing.socialmedia.index', compact(
                        'socialmedias',
                        'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $types = Socialmedia::returnTypes();

        return view('marketing.socialmedia.create', compact(
                        'types',
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
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:socialmedias',
                    'URL_name' => 'required:socialmedias',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $socialmedia = new Socialmedia;
            $socialmedia->fill($request->all());
            $socialmedia->account_id = auth()->user()->account_id;
            $socialmedia->save();

            return view('marketing.socialmedia.show', compact(
                            'socialmedia',
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Socialmedia  $socialmedia
     * @return \Illuminate\Http\Response
     */
    public function show(Socialmedia $socialmedia) {

        return view('marketing.socialmedia.show', compact(
                        'socialmedia',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Socialmedia  $socialmedia
     * @return \Illuminate\Http\Response
     */
    public function edit(Socialmedia $socialmedia) {
        $types = Socialmedia::returnTypes();
        $status = Socialmedia::returnStatus();

        return view('marketing.socialmedia.edit', compact(
                        'socialmedia',
                        'types',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Socialmedia  $socialmedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socialmedia $socialmedia) {
        $socialmedia->fill($request->all());
        $socialmedia->save();

        return view('marketing.socialmedia.show', compact(
                        'socialmedia',
        ));
    }

    /**
      public function destroy(Socialmedia $socialmedia) {
      //
      } * Remove the specified resource from storage.
     *
     * @param  \App\Models\Socialmedia  $socialmedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socialmedia $socialmedia) {
        $socialmedia->delete();
        return redirect()->action('Marketing\\SocialmediaController@index');
    }

}
