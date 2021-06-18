<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Image;
use App\Models\Contact;
use App\Models\Product;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $products = Product::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    $query->where('type', '=', $request->variation);
                })
                ->with('image')
                ->orderBy('name', 'ASC')
                ->paginate(20);

        $products->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'variation' => $request->variation,
        ]);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = myUsers();

        $total = $products->total();

        $variation = $request->variation;

        return view('sales.products.indexProducts', compact(
                        'products',
                        'contacts',
                        'accounts',
                        'users',
                        'total',
                        'variation',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

//		$companies = Company::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$contacts = Contact::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$opportunities = Opportunity::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();
//
//		$users = User::whereHas('accounts', function($query) {
//					$query->whereIn('account_id', userAccounts());
//				})
//				->get();

        $variation = $request->input('variation');

        $products = Product::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->where('type', 'LIKE', $variation)
                ->orderBy('NAME', 'ASC')
                ->get();

        $images = Image::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->where('type', 'produto')
                ->get();

        return view('sales.products.createProduct', compact(
                        'accounts',
                        'products',
                        'variation',
                        'images',
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
            'unique' => 'Já existe um contato com este :attribute.',
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:products',
                    'price' => 'required:products',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $product = new Product();
            $product->fill($request->all());
            $product->price = str_replace(",", ".", $request->price);
            $product->tax_rate = str_replace(",", ".", $request->tax_rate);
            $product->type = $request->type;
            $product->save();

            $type = $product->type;
            $variation = $request->variation;

            return view('sales.products.showProduct', compact(
                            'product',
                            'type',
                            'variation',
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request) {
        $variation = $request->variation;

        return view('sales.products.showProduct', compact(
                        'variation',
                        'product',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request) {
        $images = Image::where('account_id',  Auth::user()->account_id)
                ->where('type', 'produto')
                ->get();

        $variation = $request->variation;

        return view('sales.products.editProduct', compact(
                        'product',
                        'images',
                        'variation',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        $product->fill($request->all());
        $product->price = str_replace(",", ".", $request->price);
        $product->tax_rate = str_replace(",", ".", $request->tax_rate);
//        dd($request);
        $product->image_id = $this->saveImage($request);
        $product->save();
        $variation = $request->variation;

        return view('sales.products.showProduct', compact(
                        'product',
                        'variation',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $variation = $product->type;
        $product->delete();

        return redirect()->route('product.index', ['variation' => $variation]);
    }

    public function filter(Request $request) {
        $products = Product::where(function ($query) use ($request) {
                    $query->whereIn('account_id', userAccounts());
                    $query->where('type', '=', $request->variation);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->status) {
                        $query->where('status', '=', $request->status);
                    }
                    if ($request->category) {
                        $query->where('category', '=', $request->category);
                    }
                })
                ->orderBy('name', 'ASC')
                ->paginate(20);
//dd($invoices);
        $products->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'variation' => $request->variation,
        ]);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = myUsers();

        $total = $products->total();

        $variation = $request->variation;

        return view('sales.products.indexProducts', compact(
                        'products',
                        'contacts',
                        'accounts',
                        'users',
                        'total',
                        'variation',
        ));
    }

    public function saveImage($request) {
        if ($request->file('image')) {
            $image = new Image();
            $image->name = $request->name;
            $image->account_id = $request->account_id;
            $image->type = 'produto';
            $image->status = 'disponível';
            $path = $request->file('image')->store('users_images');
            $image->path = $path;
            $image->save();
            $imageId = $image->id;
        } else {
            $imageId = $request->image_id;
        }
        return $imageId;
    }

}
