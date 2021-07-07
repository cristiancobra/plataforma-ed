<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Socialmedia;
use Illuminate\Http\Request;

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
        $types = $this->types();

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
        $socialmedia = new Socialmedia;
        $socialmedia->fill($request->all());
        $socialmedia->account_id = auth()->user()->account_id;
        $socialmedia->save();

        return view('marketing.socialmedia.show', compact(
                        'socialmedia',
        ));
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
        $types = $this->types();
        $status = $this->socialmediaStatus();

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

    function socialmediaStatus() {
        return $status = array(
            'publicada',
            'desativada',
            'cancelada',
        );
    }

    public function types() {
        $types = [
            'minha',
            'concorrente',
        ];
        return $types;
    }

}
