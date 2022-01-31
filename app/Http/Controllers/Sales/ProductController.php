<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Shop;
use App\Models\User;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $products = Product::filterProducts($request);

        foreach ($products as $product) {
            $product->stock = Product::countStock($product);
        }
//dd($products);
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $total = $products->total();

        $variation = $request->variation;

        $categories = Product::returnCategories();
        $groups = Product::returnGroups();
        $status = Product::returnStatus();

        return view('sales.products.index', compact(
                        'products',
                        'contacts',
                        'users',
                        'total',
                        'variation',
                        'categories',
                        'groups',
                        'status',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $variation = $request->input('variation');

        $products = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'LIKE', $variation)
                ->orderBy('NAME', 'ASC')
                ->get();

        $images = Image::where('account_id', auth()->user()->account_id)
                ->where('type', 'produto')
                ->get();

        $categories = Product::returnCategories();
        $groups = Product::returnGroups();
        $status = Product::returnStatus();

        return view('sales.products.create', compact(
                        'products',
                        'variation',
                        'images',
                        'categories',
                        'groups',
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
            $variation = $request->input('variation');

            $product = new Product();
            $product->fill($request->all());
            $product->account_id = auth()->user()->account_id;
            $product->price = removeCurrency($request->price);
            if ($variation == 'receita') {
                $product->price = $product->price;
            } else {
                $product->price = $product->price * -1;
            }
            $product->tax_rate = str_replace(",", ".", $request->tax_rate);
            $product->type = $variation;
            $product->image_id = $this->saveImage($request);
            $product->shop = $request->has('shop') ? 1 : 0;
            $product->save();

            $type = $variation;

            return redirect()->route('product.show', compact(
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
        $product->taxPrice = $product->price * $product->tax_rate / 100;
        $product->margin = $product->price - $product->taxPrice - $product->cost1 - $product->cost2 - $product->cost3;

        $product->stock = Product::countStock($product);

        $status = $product->status;
        $priority = $product->points;

        return view('sales.products.show', compact(
                        'variation',
                        'product',
                        'status',
                        'priority',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request) {
        $variation = $request->variation;
        if ($variation == 'receita') {
            $product->price = $product->price;
        } else {
            $product->price = $product->price * -1;
        }

        $images = Image::where('account_id', auth()->user()->account_id)
                ->where('type', 'produto')
                ->get();

        $categories = Product::returnCategories();
        $groups = Product::returnGroups();
        $status = Product::returnStatus();

        $product->stock = Product::countStock($product);

        return view('sales.products.edit', compact(
                        'product',
                        'images',
                        'variation',
                        'categories',
                        'groups',
                        'status',
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
        $product->price = removeCurrency($request->price);
        if ($product->type == 'receita') {
            $product->price = $product->price;
        } else {
            $product->price = $product->price * -1;
        }
        $product->tax_rate = str_replace(",", ".", $request->tax_rate);
        $product->image_id = $this->saveImage($request);
        $product->shop = $request->has('shop') ? 1 : 0;
        $product->save();
        $variation = $request->variation;

        return redirect()->route('product.show', compact(
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

    public function sendToTrash(Product $product) {
        $product->trash = 1;
        $product->save();

        return redirect()->route('product.index', ['variation' => $product->type]);
    }

    public function restoreFromTrash(Product $product) {
        $product->trash = 0;
        $product->save();

        return redirect()->route('product.index', ['variation' => $product->type]);
    }

    public function filter(Request $request) {
        $products = Product::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
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
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
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

        $total = $products->total();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $variation = $request->variation;

        return view('sales.products.index', compact(
                        'products',
                        'contacts',
                        'users',
                        'total',
                        'variation',
        ));
    }

//    relatórios anuais
    public function report(Request $request) {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

        $monthlyRevenues = Proposal::monthlysTotal($year, 'receita');
        $annualRevenues = Proposal::annualTotal($year, 'receita');

        $products = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->get();

//        $products = [];
        foreach ($products as $product) {
//            $products[$product]['name'] = $product->name;
            $product['monthlys'] = Proposal::monthlysProductsTotal($year, $product, 'receita');
            $product->year = Proposal::annualProductsTotal($year, $product, 'receita');
        }

        $products = $products->sortByDesc(function ($product) {
            return $product->year;
        });

        return view('sales.products.report', compact(
                        'monthlyRevenues',
                        'annualRevenues',
                        'products',
                        'year',
                        'months',
        ));
    }

    public function saveImage($request) {
//        dd($request);
        if ($request->file('image')) {
            $image = new Image();
            $image->name = $request->name;
            $image->account_id = auth()->user()->account_id;
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

    public function public(Request $request, Product $product) {
        $product->stock = Product::countStock($product);

        $shop = Shop::where('account_id', $product->account_id)
                ->where('status', 'ativada')
                ->first();
//            dd($shop);

        if ($shop == null) {
            return redirect()->back();
        }
        $variation = $request->input('variation');
        $whatsappLink = Product::whatsappLink($product);
//            dd($variation);
//        $states = Contact::returnStates();
//        $page->with([
//            'banner',
//            'logo',
//        ]);
//
//        $user = User::where('account_id', $page->account_id)
//                ->where('perfil', 'dono')
//                ->first();
//
//        $accountType = $page->accountType(auth()->user()->account_id);
//
//        $valueOffer = Text::selectedValueOffer($page);
//        $valueOffer->text = Text::unformatText($valueOffer->text);
//        $about = Text::selectedAbout($page);
//        $about->text = Text::unformatText($about->text);
//
//        $strengths = Text::selectedStrengths($page);
//        foreach ($strengths as $strength) {
//            $strength->text = Text::unformatText($strength->text);
//        }

        return view('sales.products.public', compact(
                        'product',
                        'variation',
                        'whatsappLink',
                        'shop',
//                        'page',
//                        'states',
//                        'user',
//                        'accountType',
//                        'valueOffer',
//                        'about',
//                        'strengths',
        ));
    }

    public function redirect(Request $request, Product $product) {
        $variation = $request->input('variation');

        return redirect()->route('product.public', [
                    'product' => $product,
                    'variation' => $variation,
        ]);
    }

}
