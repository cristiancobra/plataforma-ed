<?php

namespace App\Http\Controllers\Socialmedia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use App\Lead;
use App\Models\Task;
use App\Opportunities;
use App\Models\Facebook;
use App\Models\Instagram;
use App\Models\Linkedin;
use App\Models\Twitter;
use App\Models\Pinterest;
use App\Models\Youtube;
use App\Models\Spotify;

class DashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function socialmedia() {
        $userAuth = Auth::user();
        $hoje = date("d/m/Y");

        $facebooks = Facebook::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        $instagrams = Instagram::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        $linkedins = Linkedin::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        $twitters = Twitter::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        $pinterests = Pinterest::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        $youtubes = Youtube::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();


        $spotifys = spotify::where('user_id', '=', $userAuth->id)
                ->with('users')
                ->get();

        return view('socialmedia/dashboardSocialmedia', [
            'userAuth' => $userAuth,
            'hoje' => $hoje,
            'facebooks' => $facebooks,
            'instagrams' => $instagrams,
            'linkedins' => $linkedins,
            'twitters' => $twitters,
            'pinterests' => $pinterests,
            'youtubes' => $youtubes,
            'spotify' => $spotifys,
        ]);
    }

}
