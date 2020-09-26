<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Account;
use App\Models\Facebook;
use App\Models\Instagram;
use App\Models\Linkedin;
use App\Models\Twitter;
use App\Models\Pinterest;
use App\Models\Youtube;
use App\Models\Spotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$reports = Report::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->paginate(20);

			$totalReports = $reports->count();

			return view('reports.indexReports', [
				'reports' => $reports,
				'totalReports' => $totalReports,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();
		$report = new Report();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('reports.createReport', [
				'userAuth' => $userAuth,
				'report' => $report,
				'accounts' => $accounts,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$report = new Report();
		$report->account_id = ($request->account_id);
		$report->name = ($request->name);
		$report->date = ($request->date);
		$report->status = ($request->status);
		$report->general = ($request->general);
		$report->logo = ($request->logo);
		$report->palette = ($request->palette);

//		$facebook = Facebook::where('user_id', '=', $request->user_id)->first();
//		if ($facebook == null) {
//			return Redirect::back()
//							->withErrors("Usuário não possui PÁGINA DE FACEBOOK cadastrada.");
//		}
//		$report->FB_page_name = ($facebook->page_name);
//		$report->FB_URL_name = ($facebook->URL_name);
//		$report->FB_business = ($facebook->business);
//		$report->FB_linked_instagram = ($facebook->linked_instagram);
//		$report->FB_same_site_name = ($facebook->same_site_name);
//		$report->FB_about = ($facebook->about);
//		$report->FB_feed_content = ($facebook->feed_content);
//		$report->FB_harmonic_feed = ($facebook->harmonic_feed);
//		$report->FB_SEO_descriptions = ($facebook->SEO_descriptions);
//		$report->FB_feed_images = ($facebook->feed_images);
//		$report->FB_stories = ($facebook->stories);
//		$report->FB_interaction = ($facebook->interaction);
//		$report->FB_value_ads = ($facebook->value_ads);
//
//		$instagram = Instagram::where('user_id', '=', $request->user_id)->first();
//		if ($instagram == null) {
//			return Redirect::back()
//							->withErrors("Usuário não possui CONTA DE INSTAGRAM cadastrada.");
//		}
//		$report->IG_page_name = ($instagram->page_name);
//		$report->IG_URL_name = ($instagram->URL_name);
//		$report->IG_business = ($instagram->business);
//		$report->IG_linked_facebook = ($instagram->linked_facebook);
//		$report->IG_same_site_name = ($instagram->same_site_name);
//		$report->IG_about = ($instagram->about);
//		$report->IG_linktree = ($instagram->linktree);
//		$report->IG_feed_content = ($instagram->feed_content);
//		$report->IG_harmonic_feed = ($instagram->harmonic_feed);
//		$report->IG_SEO_descriptions = ($instagram->SEO_descriptions);
//		$report->IG_feed_images = ($instagram->feed_images);
//		$report->IG_stories = ($instagram->stories);
//		$report->IG_interaction = ($instagram->interaction);
//		$report->IG_value_ads = ($instagram->value_ads);
//
//		$linkedin = Linkedin::where('user_id', '=', $request->user_id)->first();
//		if ($linkedin == null) {
//			return Redirect::back()
//							->withErrors("Usuário não possui CONTA DE LINKEDIN cadastrada.");
//		}
//		$report->IN_page_name = ($linkedin->page_name);
//		$report->IN_URL_name = ($linkedin->URL_name);
//		$report->IN_business = ($linkedin->business);
//		$report->IN_same_site_name = ($linkedin->same_site_name);
//		$report->IN_about = ($linkedin->about);
//		$report->IN_feed_content = ($linkedin->feed_content);
//		$report->IN_SEO_descriptions = ($linkedin->SEO_descriptions);
//		$report->IN_feed_images = ($linkedin->feed_images);
//		$report->IN_employee_profiles = ($linkedin->employee_profiles);
//		$report->IN_offers_job = ($linkedin->offers_job);
//		$report->IN_value_ads = ($linkedin->value_ads);
//
//		$twitter = Twitter::where('user_id', '=', $request->user_id)->first();
//		if ($twitter == null) {
//			return Redirect::back()
//							->withErrors("Usuário não possui CONTA DE TWITTER cadastrada.");
//		}
//		$report->TW_page_name = ($twitter->page_name);
//		$report->TW_URL_name = ($twitter->URL_name);
//		$report->TW_business = ($twitter->business);
//		$report->TW_linked_facebook = ($twitter->linked_facebook);
//		$report->TW_linked_site = ($twitter->linked_site);
//		$report->TW_same_site_name = ($twitter->same_site_name);
//		$report->TW_about = ($twitter->about);
//		$report->TW_feed_content = ($twitter->feed_content);
//		$report->TW_value_ads = ($twitter->value_ads);

		$report->save();

		$facebooks = Facebook::where('account_id', $report->account_id)
				->get();
		$instagrams = Instagram::where('account_id', $report->account_id)
				->get();
		$linkedins = Linkedin::where('account_id', $report->account_id)
				->get();
		$twitters = Twitter::where('account_id', $report->account_id)
				->get();
		$pinterests = Pinterest::where('account_id', $report->account_id)
				->get();
		$youtubes = Youtube::where('account_id', $report->account_id)
				->get();
		$spotifys = Spotify::where('account_id', $report->account_id)
				->get();

		return view('reports.showReport', [
			'report' => $report,
			'facebooks' => $facebooks,
			'instagrams' => $instagrams,
			'linkedins' => $linkedins,
			'twitters' => $twitters,
			'pinterests' => $pinterests,
			'youtubes' => $youtubes,
			'spotifys' => $spotifys,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function show(Report $report) {
		if (Auth::check() == true) {
			$userAuth = Auth::user();

			if (Auth::check()) {
				$facebooks = Facebook::where('account_id', $report->account_id)
						->get();
				$instagrams = Instagram::where('account_id', $report->account_id)
						->get();
				$linkedins = Linkedin::where('account_id', $report->account_id)
						->get();
				$twitters = Twitter::where('account_id', $report->account_id)
						->get();
				$pinterests = Pinterest::where('account_id', $report->account_id)
						->get();
				$youtubes = Youtube::where('account_id', $report->account_id)
						->get();
				$spotifys = Spotify::where('account_id', $report->account_id)
						->get();

				return view('reports.showReport', [
					'report' => $report,
					'facebooks' => $facebooks,
					'instagrams' => $instagrams,
					'linkedins' => $linkedins,
					'twitters' => $twitters,
					'pinterests' => $pinterests,
					'youtubes' => $youtubes,
					'spotifys' => $spotifys,
					'userAuth' => $userAuth,
				]);
			} else {
				return redirect('/');
			}
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Report $report) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();


			return view('reports.editReport', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'report' => $report,
			]);
		} else {
			return redirect('/');
		}

		return view('reports.editReport', [
			'userAuth' => $userAuth,
			'report' => $report,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Report $report) {
		$userAuth = Auth::user();

		$report->fill($request->all());
		$report->save();

		return view('reports.showReport', [
			'userAuth' => $userAuth,
			'report' => $report,
				//'emails' => $emails,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ModelsReport  $modelsReport
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Report $report) {
		$report->delete();
		return redirect()->route('report.index');
	}

	public function generatePDF(Report $report) {

		$pdf = PDF::loadView('reports.showReport', $report);
//		    $pdf = PDF::loadView('licencie_structure.show', compact('licencie'));
		$pdf->loadHTML('<h1>Test</h1>');
		$pdf->save(storage_path() . '_relatorio.pdf');
		$pdf->download('relatorio.pdf');
	}

	public function FB_save(Request $request, $id) {
		$facebook = Facebook::where('id', $request->facebook_id)
				->first();

		$report = Report::find($id);

		$report->FB_page_name = $facebook->page_name;
		$report->FB_URL_name = $facebook->URL_name;
		$report->FB_business = $facebook->business;
		$report->FB_linked_instagram = $facebook->linked_instagram;
		$report->FB_same_site_name = $facebook->same_site_name;
		$report->FB_about = $facebook->about;
		$report->FB_feed_content = $facebook->feed_content;
		$report->FB_harmonic_feed = $facebook->harmonic_feed;
		$report->FB_SEO_descriptions = $facebook->SEO_descriptions;
		$report->FB_feed_images = $facebook->feed_images;
		$report->FB_stories = $facebook->stories;
		$report->FB_interaction = $facebook->interaction;
		$report->FB_value_ads = $facebook->value_ads;

		$report->save();

		return back();
	}

	public function IG_save(Request $request, $id) {
		$instagram = Instagram::where('id', $request->instagram_id)
				->first();

		$report = Report::find($id);

		$report->IG_page_name = $instagram->page_name;
		$report->IG_URL_name = $instagram->URL_name;
		$report->IG_business = $instagram->business;
		$report->IG_linked_facebook = $instagram->linked_facebook;
		$report->IG_same_site_name = $instagram->same_site_name;
		$report->IG_about = $instagram->about;
		$report->IG_feed_content = $instagram->feed_content;
		$report->IG_harmonic_feed = $instagram->harmonic_feed;
		$report->IG_SEO_descriptions = $instagram->SEO_descriptions;
		$report->IG_feed_images = $instagram->feed_images;
		$report->IG_stories = $instagram->stories;
		$report->IG_interaction = $instagram->interaction;
		$report->IG_linktree = $instagram->linktree;
		$report->IG_value_ads = $instagram->value_ads;

		$report->save();

		return back();
	}

	public function IN_save(Request $request, $id) {
		$linkedin = Linkedin::where('id', $request->linkedin_id)
				->first();

		$report = Report::find($id);

		$report->IN_page_name = $linkedin->page_name;
		$report->IN_URL_name = $linkedin->URL_name;
		$report->IN_business = $linkedin->business;
		$report->IN_same_site_name = $linkedin->same_site_name;
		$report->IN_about = $linkedin->about;
		$report->IN_feed_content = $linkedin->feed_content;
		$report->IN_SEO_descriptions = $linkedin->SEO_descriptions;
		$report->IN_feed_images = $linkedin->feed_images;
		$report->IN_employee_profiles = $linkedin->employee_profiles;
		$report->IN_value_ads = $linkedin->value_ads;

		$report->save();

		return back();
	}

	public function TW_save(Request $request, $id) {
		$twitter = Twitter::where('id', $request->twitter_id)
				->first();

		$report = Report::find($id);

		$report->TW_page_name = $twitter->page_name;
		$report->TW_URL_name = $twitter->URL_name;
		$report->TW_business = $twitter->business;
		$report->TW_linked_facebook = $twitter->linked_facebook;
		$report->TW_linked_site = $twitter->linked_site;
		$report->TW_same_site_name = $twitter->same_site_name;
		$report->TW_about = $twitter->about;
		$report->TW_feed_content = $twitter->feed_content;
		$report->TW_value_ads = $twitter->value_ads;
		$report->save();

		return back();
	}

	public function PI_save(Request $request, $id) {
		$pinterest = Pinterest::where('id', $request->pinterest_id)
				->first();
		$report = Report::find($id);

		$report->PI_page_name = $pinterest->page_name;
		$report->PI_URL_name = $pinterest->URL_name;
		$report->PI_business = $pinterest->business;
		$report->PI_linked_site = $pinterest->linked_site;
		$report->PI_same_site_name = $pinterest->same_site_name;
		$report->PI_about = $pinterest->about;
		$report->PI_pin_content = $pinterest->pin_content;
		$report->PI_value_ads = $pinterest->value_ads;

		$report->save();

		return back();
	}

	public function YT_save(Request $request, $id) {
		$youtube = Youtube::where('id', $request->youtube_id)
				->first();

		$report = Report::find($id);

		$report->YT_page_name = $youtube->page_name;
		$report->YT_URL_name = $youtube->URL_name;
		$report->YT_linked_site = $youtube->linked_site;
		$report->YT_about = $youtube->about;
		$report->YT_follow_channel = $youtube->follow_channel;
		$report->YT_feed_member = $youtube->feed_member;
		$report->YT_linked_virtualstore = $youtube->linked_virtualstore;
		$report->YT_video_banner = $youtube->video_banner;
		$report->YT_legend = $youtube->legend;
		$report->YT_SEO_content = $youtube->SEO_content;
		$report->YT_value_ads = $youtube->value_ads;

		$report->save();

		return back();
	}

	public function SP_save(Request  $request, $id) {
		$spotify = Spotify::where('id', $request->spotify_id)
				->first();

		$report = Report::find($id);

		$report->SP_page_name = $spotify->page_name;
		$report->SP_URL_name = $spotify->URL_name;
		$report->SP_same_site_name = $spotify->same_site_name;
		$report->SP_about = $spotify->about;
		$report->SP_feed_content = $spotify->feed_content;
		$report->SP_value_ads = $spotify->value_ads;

		$report->save();

		return back();
	}

}
