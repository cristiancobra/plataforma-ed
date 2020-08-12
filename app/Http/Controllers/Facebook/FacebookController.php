<?php

namespace App\Http\Controllers\Facebook;

use App\Models\Facebook;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Auth::user();
		if ($user->perfil == "administrador") {
			$facebooks = Facebook::where('id', '>=', 0)->orderBy('PAGE_NAME', 'asc')->get();
			$totalFacebooks = $facebooks->count();
		} else {
			$facebooks = Facebook::where('user_id', '=', $user->id)->with('users')->get();
		}

		return view('facebooks.indexFacebooks', [
			'facebooks' => $facebooks,
			'totalFacebooks' => $totalFacebooks,
			'user' => $user,
		]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   		$facebook = new \App\Models\Facebook();
		$user = Auth::user();
		$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('facebooks.createFacebook', [
			'user' => $user,
			'users' => $users,
			'facebook' => $facebook,
			'accounts' => $accounts,
		]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$facebook = new \App\Models\Facebook();
		$facebook->user_id = ($request->user_id);
		$facebook->page_name = ($request->page_name);
		$facebook->linked_instagram = ($request->linked_instagram);
		$facebook->same_site_name = ($request->same_site_name);
		$facebook->about = ($request->about);
		$facebook->feed_content = ($request->feed_content);
		$facebook->harmonic_feed = ($request->harmonic_feed);
		$facebook->SEO_descriptions = ($request->SEO_descriptions);
		$facebook->feed_images = ($request->feed_images);
		$facebook->stories = ($request->stories);
		$facebook->interaction = ($request->interaction);
		$facebook->pay_ads = ($request->pay_ads);
		$facebook->value_ads = ($request->value_ads);
		$facebook->save();

		$facebooks = \App\Models\Facebook::all();
		$user = Auth::user();

		return redirect()->action('Facebook\\FacebookController@index');
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function show(Facebook $facebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Facebook $facebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facebook $facebook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facebook $facebook)
    {
        //
    }
}
