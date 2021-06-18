<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Planning;
use App\Models\Product;
use App\Models\Transaction;

class PlanningController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $plannings = Planning::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $plannings->count();

        return view('financial.plannings.indexPlannings', compact(
                        'plannings',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $products = Product::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $name = "name0001";
        $amount = "amount0001";
        $hours = "hours0001";
        $cost = "cost0001";
        $tax_rate = "tax_rate0001";
        $price = "price0001";
        $margin = "margin0001";

        return view('financial.plannings.createPlanning', compact(
            'products',
            'name',
            'amount',
            'hours',
            'cost',
            'tax_rate',
            'price',
            'margin',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $planning = new Planning();
        $planning->account_id = auth()->user()->account_id;
        $planning->name = ($request->name);
        $planning->months = ($request->months);
        $planning->expenses = ($request->expenses);
        $planning->status = ($request->status);

        $name = "name0001";
        $amount = "amount0001";
        $hours = "hours0001";
        $cost = "cost0001";
        $tax_rate = "tax_rate0001";
        $price = "price0001";
        $margin = "margin0001";

        $totalAmount = 0;
        $totalHours = 0;
        $totalCost = 0;
        $totalTax_rate = 0;
        $totalPrice = 0;
        $totalMargin = 0;

        while ($request->$name != null) {
            $planning->$name = $request->$name;

            $planning->$amount = $request->$amount;
            $totalAmount = $totalAmount + $request->$amount;

            $planning->$hours = $request->$hours * $request->$amount;
            $totalHours = $totalHours + $planning->$hours;

            $planning->$cost = $request->$cost * $request->$amount;
            $totalCost = $totalCost + $planning->$cost;

            $planning->$tax_rate = $request->$tax_rate * $request->$amount;
            $totalTax_rate = $totalTax_rate + $planning->$tax_rate;

            $planning->$price = $request->$price * $request->$amount;
            $totalPrice = $totalPrice + $planning->$price;

            $planning->$margin = $request->$margin * $request->$amount;
            $totalMargin = $totalMargin + $planning->$margin;

            $name++;
            $amount++;
            $hours++;
            $cost++;
            $tax_rate++;
            $price++;
            $margin++;
        }
        $planning->totalAmount = $totalAmount;
        $planning->totalHours = $totalHours;
        $planning->totalCost = $totalCost;
        $planning->totalTax_rate = $totalTax_rate;
        $planning->totalPrice = $totalPrice;
        $planning->totalMargin = $totalMargin;
        $planning->totalBalance = $totalMargin - $planning->expenses;
        $planning->save();

        return redirect()->action('Financial\\PlanningController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning) {
        $name = "name0001";
        $amount = "amount0001";
        $hours = "hours0001";
        $cost = "cost0001";
        $tax_rate = "tax_rate0001";
        $price = "price0001";
        $margin = "margin0001";

        return view('financial.plannings.showPlanning', compact(
            'planning',
            'name',
            'amount',
            'hours',
            'cost',
            'tax_rate',
            'price',
            'margin',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning) {
            return view('financial.plannings.editPlanning', compact(
                'planning',
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planning $planning) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning) {
        $planning->delete();
        return redirect()->action('Financial\\PlanningController@index');
    }

}
