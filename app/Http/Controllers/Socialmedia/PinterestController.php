<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Pinterest;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinterestController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userAuth = Auth::user();
        if ($userAuth->perfil == "administrador") {
            $pinterests = Pinterest::where('id', '>=', 0)
                    ->with('users')
                    ->orderBy('PAGE_NAME', 'asc')
                    ->get();
        } else {
            $pinterests = Pinterest::where('user_id', '=', $userAuth->id)
                    ->with('users')
                    ->get();
        }

        $score = $pinterests->count();
        return view('socialmedia.pinterests.indexPinterests', [
            'pinterests' => $pinterests,
            'userAuth' => $userAuth,
            'score' => $score,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $userAuth = Auth::user();
        if ($userAuth->perfil == "administrador") {
            $users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
        } else {
            $users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
        }

        $pinterest = new Pinterest();

        $accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

        return view('socialmedia.pinterests.createPinterest', [
            'userAuth' => $userAuth,
            'users' => $users,
            'pinterest' => $pinterest,
            'accounts' => $accounts,
        ]);
    }

    //

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        Pinterest::create($request->all());

        return redirect()->action('Socialmedia\\PinterestController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pinterest  $pinterest
     * @return \Illuminate\Http\Response
     */
    public function show(Pinterest $pinterest) {
        $userAuth = Auth::user();

        return view('socialmedia.pinterests.showPinterest', [
            'pinterest' => $pinterest,
            'userAuth' => $userAuth,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pinterest  $pinterest
     * @return \Illuminate\Http\Response
     */
    public function edit(Pinterest $pinterest) {
        $userAuth = Auth::user();
        if ($userAuth->perfil == "administrador") {
            $users = User::where('id', '>=', 0)
                    ->orderBy('NAME', 'asc')
                    ->get();
        } else {
            $users = User::where('id', '=', $userAuth->id)
                    ->with('accounts')
                    ->get();
        }

        $accounts = Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

        return view('socialmedia.pinterests.editPinterest', [
            'userAuth' => $userAuth,
            'users' => $users,
            'accounts' => $accounts,
            'pinterest' => $pinterest,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pinterest  $pinterest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pinterest $pinterest) {
        $userAuth = Auth::user();

        $pinterest->fill($request->all());
        $pinterest->save();

        return view('socialmedia.pinterests.showPinterest', [
            'pinterest' => $pinterest,
            'userAuth' => $userAuth,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pinterest  $pinterest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinterest $pinterest) {
        $pinterest->delete();
        return redirect()->action('Socialmedia\\PinterestController@index');
    }

    public function scoreBar($score) {
        if ($score)
            ;
    }

}
