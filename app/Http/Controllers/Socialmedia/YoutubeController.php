<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Youtube;
use Illuminate\Http\Request;
use App\Models\Account;
use App\User;
use Illuminate\Support\Facades\Auth;

class YoutubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index() {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$youtubes = Youtube::where('id', '>=', 0)
					->with('users')
					->orderBy('PAGE_NAME', 'asc')
					->get();
		} else {
			$youtubes = Youtube::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}

		$score = $youtubes->count();
//		$totalGBs = $emails->sum('storage');

		return view('socialmedia.youtubes.indexYoutubes', [
			'youtubes' => $youtubes,
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

		$youtube = new Youtube();

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.youtubes.createYoutube', [
			'userAuth' => $userAuth,
			'users' => $users,
			'youtube' => $youtube,
			'accounts' => $accounts,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		Youtube::create($request->all());

		return redirect()->action('Socialmedia\\YoutubeController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function show(Youtube $youtube) {
		$userAuth = Auth::user();

		return view('socialmedia.youtubes.showYoutube', [
			'youtube' => $youtube,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Youtube $youtube) {
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

		return view('socialmedia.youtubes.editYoutube', [
			'userAuth' => $userAuth,
			'users' => $users,
			'accounts' => $accounts,
			'youtube' => $youtube,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Youtube $youtube) {
		$userAuth = Auth::user();

		$youtube->fill($request->all());
		$youtube->save();

		return view('socialmedia.youtubes.showYoutube', [
			'youtube' => $youtube,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Youtube $youtube) {
		$youtube->delete();
		return redirect()->action('Socialmedia\\YoutubeController@index');
	}

	public function scoreBar($score) {
		if ($score);
	}
}
