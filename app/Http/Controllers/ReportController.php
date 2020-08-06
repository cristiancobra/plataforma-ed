<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
			$reports = Report::where('id', '>=', 0)->orderBy('ID', 'asc')->get();
			$totalReports = $reports->count();
		} else {
			$reports = Report::where('user_id', '=', $user->id)->with('users')->get();
		}

		return view('reports.listAllReports', [
			'reports' => $reports,
			'totalReports' => $totalReports,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelsReport  $modelsReport
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
		$user = Auth::user();
		$reports = Report::where('id', '=', $user->id)->with('users')->get();
		return view('reports.showReport', [
			'report' => $report,
		//	'reports' => $reports,
			'user' => $user,
		]);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelsReport  $modelsReport
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelsReport  $modelsReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModelsReport  $modelsReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
