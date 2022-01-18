<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Planning;
use App\Models\Product;
use App\Models\ProductPlanning;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class PlanningController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $plannings = Planning::where('account_id', auth()->user()->account_id)
                ->where('trash', '!=', 1)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $plannings->count();

        return view('administrative.plannings.index', compact(
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
                ->where('type', 'receita')
                ->where('status', 'disponível')
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('administrative.plannings.create', compact(
                        'products',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];

        $validator = Validator::make($request->all(), [
                    'name' => 'required:plannings',
                    'date_creation' => 'required:plannings',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $planning = new Planning();
            $planning->fill($request->all());
            $planning->account_id = auth()->user()->account_id;
            
            $planning->expenses_prolabore = removeCurrency($request->expenses_prolabore);
            $planning->expenses_salary = removeCurrency($request->expenses_salary);
            $planning->expenses_marketing = removeCurrency($request->expenses_marketing);
            $planning->expenses_production = removeCurrency($request->expenses_production);
            $planning->expenses_accounting = removeCurrency($request->expenses_accounting);
            $planning->expenses_legal = removeCurrency($request->expenses_legal);
            $planning->expenses_infrastructure = removeCurrency($request->expenses_infrastructure);
            $planning->expenses_working_capital = removeCurrency($request->expenses_working_capital);
            
            $planning->expenses = $planning->expenses_prolabore
                    + $planning->expenses_salary
                    + $planning->expenses_marketing
                    + $planning->expenses_production
                    + $planning->expenses_accounting
                    + $planning->expenses_legal
                    + $planning->expenses_infrastructure
                    + $planning->expenses_working_capital;
            
            $planning->save();

            // Cria e salva uma InvoiceLine para cada PRODUTO com quantidade maior que zero
            $totalAmount = 0;
            $totalPrice = 0;
            $totalTaxrate = 0;
            foreach ($request->product_id as $key => $value) {
                if ($request->product_amount [$key] > 0) {
                    $data = array(
                        'planning_id' => $planning->id,
                        'product_id' => $request->product_id [$key],
                        'subtotal_amount' => $request->product_amount [$key],
                        'subtotal_cost' => $request->product_amount [$key] * $request->product_cost [$key],
                        'subtotal_tax_rate' => $request->product_amount [$key] * $request->product_tax_rate [$key],
                        'subtotal_margin' => $request->product_amount [$key] * $request->product_margin [$key],
                        'subtotal_price' => $request->product_amount [$key] * removeCurrency($request->product_price [$key]),
                    );
                    $totalPrice = $totalPrice + $data['subtotal_price'];
                    $totalAmount += $data['subtotal_amount'];
                    $totalTaxrate = $totalTaxrate + $data['subtotal_tax_rate'];
                    ProductPlanning::insert($data);
                }
            }
            $planning->total_price = $totalPrice;
            $planning->total_amount = $totalAmount;
            $planning->update();

            return redirect()->route('planning.show', compact('planning'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning) {
        $productsPlannings = ProductPlanning::where('planning_id', $planning->id)
                ->get();

        $counter = 1;
        $months = [];
        $totalAmount = 0;
        $totalExpenses = 0;
        $totalRevenues = 0;
//        $totalMargin = 0;
        $totalIncome = 0;
        $totalAccumulatedIncome = 0;

        while ($counter <= $planning->months) {
            if ($counter == 1) {
                $sumAmount = $planning->total_amount;
                $sumExpenses = $planning->expenses;
                $sumRevenues = $planning->total_price;
//                $sumMargin = $planning->total_margin - $planning->expenses;
                $sumIncome = $planning->total_price - $planning->expenses;
                $accumulatedIncome = $sumIncome;
            } else {
                $sumAmount += ($sumAmount * $planning->growth_rate / 100);
                $sumExpenses += ($sumExpenses * $planning->increased_expenses / 100);
                $sumRevenues += ($sumRevenues * $planning->growth_rate / 100);
                $sumIncome = $sumRevenues - $sumExpenses;
                $accumulatedIncome +=  $sumIncome;
            }
            $totalAmount += $sumAmount;
            $totalExpenses += $sumExpenses;
            $totalRevenues += $sumRevenues;
//            $totalMargin += $sumMargin;
            $totalIncome += $sumIncome;
//            $totalAccumulatedIncome += $accumulatedIncome;

            $months[$counter]['month'] = $counter;
            $months[$counter]['sumAmount'] = $sumAmount;
            $months[$counter]['sumExpenses'] = $sumExpenses;
            $months[$counter]['sumRevenues'] = $sumRevenues;
            $months[$counter]['sumIncome'] = $sumIncome;
            $months[$counter]['accumulatedIncome'] = $accumulatedIncome;
            $months['totalAmount'] = $totalAmount;
            $months['totalExpenses'] = $totalExpenses;
            $months['totalRevenues'] = $totalRevenues;
//            $months['totalMargin'] = $totalMargin;
            $months['totalIncome'] = $totalIncome;
            $months['totalAccumulatedIncome'] = $accumulatedIncome;
            $counter++;
        }
        
        $totalValution = $months['totalAccumulatedIncome'];
        $valuation30 = $totalValution - ($totalValution * 0.3);
        $valuation40 = $totalValution - ($totalValution * 0.4);
        $valuation50 = $totalValution - ($totalValution * 0.5);

        return view('administrative.plannings.show', compact(
                        'planning',
                        'productsPlannings',
                        'months',
                        'valuation30',
                        'valuation40',
                        'valuation50',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning) {
        return view('administrative.plannings.edit', compact(
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
        $planning->fill($request->all());             
        
            $planning->expenses_prolabore = removeCurrency($request->expenses_prolabore);
            $planning->expenses_salary = removeCurrency($request->expenses_salary);
            $planning->expenses_marketing = removeCurrency($request->expenses_marketing);
            $planning->expenses_production = removeCurrency($request->expenses_production);
            $planning->expenses_accounting = removeCurrency($request->expenses_accounting);
            $planning->expenses_legal = removeCurrency($request->expenses_lega);
            $planning->expenses_infrastructure = removeCurrency($request->expenses_infrastructure);
            $planning->expenses_working_capital = removeCurrency($request->expenses_working_capital);
            
            $planning->expenses = $planning->expenses_prolabore
                    + $planning->expenses_salary
                    + $planning->expenses_marketing
                    + $planning->expenses_production
                    + $planning->expenses_accounting
                    + $planning->expenses_legal
                    + $planning->expenses_infrastructure
                    + $planning->expenses_working_capital;
                          
        $planning->save();
            

        return redirect()->route('planning.show', [$planning]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning) {
        $planning->delete();
        return redirect()->action('Administrative\\PlanningController@index');
    }
    
        
    public function sendToTrash(Planning $planning) {
        $planning->trash = 1;
        $planning->save();

        return redirect()->back();
    }

    public function restoreFromTrash(Planning $planning) {
        $planning->trash = 0;
        $planning->save();

        return redirect()->back();
    }

}
