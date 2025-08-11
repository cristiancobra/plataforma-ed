<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $banners = Image::myBanners();
        $logos =Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->where('type', 'logo')
                ->get();

//        $formFields = Page::formFields();
//        $templates = Page::listTemplates();
//        $states = returnStates();
        $status = Shop::returnStatus();

        return view('sales.shops.create', compact(
                        'banners',
                        'logos',
                        'status',
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
                    'name' => 'required:shops',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $shop = new Shop();
            $shop->fill($request->all());
            $shop->account_id = auth()->user()->account_id;
            $shop->save();

            return redirect()->route('shop.edit', [$shop]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop) {
        $banners = Image::myBanners();
        $logos =Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->where('type', 'logo')
                ->get();

        $status = Shop::returnStatus();
        
        return view('sales.shops.edit', compact(
                        'shop',
                        'banners',
                        'logos',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop) {
  $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:pages',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $shop->fill($request->all());
            $shop->save();

            return redirect()->route('dashboard.sales');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop) {
        //
    }

}
