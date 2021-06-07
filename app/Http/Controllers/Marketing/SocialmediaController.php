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
        $accounts = userAccounts();

        $socialmedias = Socialmedia::whereIn('account_id', userAccounts())
                ->with("account")
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $socialmedias->total();

        return view('marketing.socialmedia.index', compact(
                        'accounts',
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
        $accounts = Account::whereIn('id', userAccounts())
                ->get();

        $types = $this->types();

        return view('marketing.socialmedia.create', compact(
                        'accounts',
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
        $accounts = Account::whereIn('id', userAccounts())
                ->get();
        return view('marketing.socialmedia.show', compact(
                        'accounts',
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
        $accounts = Account::whereIn('id', userAccounts())
                ->get();
        $types = $this->types();
        $status = $this->socialmediaStatus();
        
        return view('marketing.socialmedia.edit', compact(
                        'accounts',
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

//		$invoices = Invoice::where('opportunity_id', $socialmedia->id)
//				->orderBy('PAY_DAY', 'ASC')
//				->get();
//
//		$tasks = Task::where('opportunity_id', $socialmedia->id)
//				->get();
//			$contracts = Contract::where('opportunity_id', $opportunity->id)
//				->get();
//
//		$contactCompanies = Company::whereHas('contacts', function ($query) use($opportunity) {
//					$query->where('contacts.id', $opportunity->contact_id);
//				})
//				->get();

        return view('marketing.socialmedia.showSocialmedia', compact(
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
