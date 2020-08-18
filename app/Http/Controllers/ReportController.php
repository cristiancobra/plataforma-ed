<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Facebook;
use App\Models\Instagram;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Redirect;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$reports = Report::where('id', '>=', 0)->orderBy('ID', 'asc')->get();
			$totalReports = $reports->count();
		} else {
			$reports = Report::where('user_id', '=', $userAuth->id)->with('users')->get();
		}

		return view('reports.indexReports', [
			'reports' => $reports,
			'totalReports' => $totalReports,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$report = new Report();
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
		}
//	$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('reports.createReport', [
			'userAuth' => $userAuth,
			'users' => $users,
			'report' => $report,
				//		'accounts' => $accounts,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$report = new Report();
		$report->user_id = ($request->user_id);
		$report->name = ($request->name);
		$report->date = ($request->date);
		$report->status = ($request->status);
		$report->logo = ($request->logo);
		$report->palette = ($request->palette);

		$facebook = Facebook::where('user_id', '=', $request->user_id)->first();
		if ($facebook == null) {
			return Redirect::back()
							->withErrors("Usuário não possui PÁGINA DE FACEBOOK cadastrada.");
		}
		$report->FB_page_name = ($facebook->page_name);
		$report->FB_URL_name = ($facebook->URL_name);
		$report->FB_business = ($facebook->business);
		$report->FB_linked_instagram = ($facebook->linked_instagram);
		$report->FB_same_site_name = ($facebook->same_site_name);
		$report->FB_about = ($facebook->about);
		$report->FB_feed_content = ($facebook->feed_content);
		$report->FB_harmonic_feed = ($facebook->harmonic_feed);
		$report->FB_SEO_descriptions = ($facebook->SEO_descriptions);
		$report->FB_feed_images = ($facebook->feed_images);
		$report->FB_stories = ($facebook->stories);
		$report->FB_interaction = ($facebook->interaction);
		$report->FB_value_ads = ($facebook->value_ads);

		$instagram = Instagram::where('user_id', '=', $request->user_id)->first();
		if ($instagram == null) {
			return Redirect::back()
							->withErrors("Usuário não possui CONTA DE INSTAGRAM cadastrada.");
		}
		$report->IG_page_name = ($instagram->page_name);
		$report->IG_URL_name = ($instagram->URL_name);
		$report->IG_business = ($instagram->business);
		$report->IG_linked_facebook = ($instagram->linked_facebook);
		$report->IG_same_site_name = ($instagram->same_site_name);
		$report->IG_about = ($instagram->about);
		$report->IG_linktree = ($instagram->linktree);
		$report->IG_feed_content = ($instagram->feed_content);
		$report->IG_harmonic_feed = ($instagram->harmonic_feed);
		$report->IG_SEO_descriptions = ($instagram->SEO_descriptions);
		$report->IG_feed_images = ($instagram->feed_images);
		$report->IG_stories = ($instagram->stories);
		$report->IG_interaction = ($instagram->interaction);
		$report->IG_value_ads = ($instagram->value_ads);

		$report->save();

		$reports = \App\Models\Report::all();
		$user = Auth::user();

		return redirect()->action('ReportController@index');
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
			$reports = Report::where('id', '=', $userAuth->id)->with('users')->get();

			if ($userAuth->perfil == "administrador") {
				$reports = Report::where('id', '>=', 0)->orderBy('DATE', 'asc')->get();
				$totalReports = $reports->count();
			} else {
				$reports = Report::where('user_id', '=', $userAuth->id)->with('users')->get();
			}
			$totalReports = $reports->count();

			return view('reports.showReport', [
				'report' => $report,
				'reports' => $reports,
				'totalReports' => $totalReports,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect()->guest('login');
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

		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
			$reports = Report::where('id', '>=', 0)
					->with('users')
					->orderBy('DATE', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->first();
			$reports = Report::where('id', '>=', 0)
					->with('users')
					->orderBy('DATE', 'asc')
					->get();
		}

		return view('reports.editReport', [
			'userAuth' => $userAuth,
			'users' => $users,
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
		$report->user_id = ($request->user_id);
		$report->name = ($request->name);
		$report->date = ($request->date);
		$report->status = ($request->status);
		$report->logo = ($request->logo);
		$report->palette = ($request->palette);

		$facebook = Facebook::where('user_id', '=', $request->user_id)->with('users')->first();
		$report->FB_page_name = ($facebook->page_name);
		$report->FB_URL_name = ($facebook->URL_name);
		$report->FB_business = ($facebook->business);
		$report->FB_linked_instagram = ($facebook->linked_instagram);
		$report->FB_same_site_name = ($facebook->same_site_name);
		$report->FB_about = ($facebook->about);
		$report->FB_feed_content = ($facebook->feed_content);
		$report->FB_harmonic_feed = ($facebook->harmonic_feed);
		$report->FB_SEO_descriptions = ($facebook->SEO_descriptions);
		$report->FB_feed_images = ($facebook->feed_images);
		$report->FB_stories = ($facebook->stories);
		$report->FB_interaction = ($facebook->interaction);
		$report->FB_value_ads = ($facebook->value_ads);

		$instagram = Instagram::where('user_id', '=', $request->user_id)->with('users')->first();
		$report->IG_page_name = ($instagram->page_name);
		$report->IG_URL_name = ($instagram->URL_name);
		$report->IG_business = ($instagram->business);
		$report->IG_linked_facebook = ($instagram->linked_facebook);
		$report->IG_same_site_name = ($instagram->same_site_name);
		$report->IG_about = ($instagram->about);
		$report->IG_linktree = ($instagram->linktree);
		$report->IG_feed_content = ($instagram->feed_content);
		$report->IG_harmonic_feed = ($instagram->harmonic_feed);
		$report->IG_SEO_descriptions = ($instagram->SEO_descriptions);
		$report->IG_feed_images = ($instagram->feed_images);
		$report->IG_stories = ($instagram->stories);
		$report->IG_interaction = ($instagram->interaction);
		$report->IG_value_ads = ($instagram->value_ads);
		$report->save();

		$userAuth = Auth::user();

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
//
	}

	public function generatePDF(Report $report) {

		$pdf = PDF::loadView('reports.showReport', $report);
//		    $pdf = PDF::loadView('licencie_structure.show', compact('licencie'));
		$pdf->loadHTML('<h1>Test</h1>');
		$pdf->save(storage_path() . '_relatorio.pdf');
		$pdf->download('relatorio.pdf');
	}

}
