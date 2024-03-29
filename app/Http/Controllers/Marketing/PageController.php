<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Product;
use App\Models\Text;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pages = Page::where('account_id', auth()->user()->account_id)
                ->with([
                    'banner',
                    'logo',
                    'biography',
                    'contacts',
                ])
                ->get();

        return view('marketing.pages.index', compact(
                        'pages',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $images = Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->where('type', 'marketing')
                ->get();

        $banners = Image::myBanners();

        $marketingImages = Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->get();

        $logos = $marketingImages->where('status', 'disponível');

        $copys = Text::where('account_id', auth()->user()->account_id)
                ->where('type', 'copy de venda')
                ->get();

        $biographies = Text::where('account_id', auth()->user()->account_id)
                ->where('type', 'biografia')
                ->get();

        $formFields = Page::formFields();
        $templates = Page::listTemplates();
        $states = returnStates();
        $status = Page::returnStatus();

        //texts
        $valueOffer = Text::myValueOffer();
        $about = Text::myAbout();
        $strengths = Text::myStrengths();

        return view('marketing.pages.create', compact(
                        'images',
                        'banners',
                        'marketingImages',
                        'logos',
                        'copys',
                        'biographies',
                        'formFields',
                        'templates',
                        'states',
                        'status',
                        'valueOffer',
                        'about',
                        'strengths',
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
                    'name' => 'required:pages',
                    'slug' => 'required:pages',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $page = new Page();
            $page->fill($request->all());
            $page->account_id = auth()->user()->account_id;
            $page->authorization_data = 1;
            $page->contact_first_name = $request->has('contact_first_name') ? 1 : 0;
            $page->contact_last_name = $request->has('contact_last_name') ? 1 : 0;
            $page->contact_email = $request->has('contact_email') ? 1 : 0;
            $page->contact_phone = $request->has('contact_phone') ? 1 : 0;
            $page->contact_site = $request->has('contact_site') ? 1 : 0;
            $page->contact_address = $request->has('contact_address') ? 1 : 0;
            $page->contact_neighborhood = $request->has('contact_neighborhood') ? 1 : 0;
            $page->contact_city = $request->has('contact_city') ? 1 : 0;
            $page->contact_state = $request->has('contact_state') ? 1 : 0;
            $page->contact_country = $request->has('contact_country') ? 1 : 0;
            $page->contact_upload_image = $request->has('contact_upload_image') ? 1 : 0;
            $page->authorization_contact = $request->has('authorization_contact') ? 1 : 0;
            $page->authorization_newsletter = $request->has('authorization_newsletter') ? 1 : 0;
            $page->save();

            return redirect()->route('page.edit', [$page]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page) {

        return view('marketing.pages.show', compact(
                        'page',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page) {

        $banners = Image::myBanners();

        $marketingImages = Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->get();

        $logos = $marketingImages->where('status', 'disponível');

        $copys = Text::where('account_id', auth()->user()->account_id)
                ->where('type', 'copy de venda')
                ->get();

        $biographies = Text::where('account_id', auth()->user()->account_id)
                ->where('type', 'biografia')
                ->get();

        if ($page->biography) {
            $biographyName = Text::find($page->biography)
                    ->pluck('name');
        } else {
            $biographyName = 'desativado';
        }

        //texts
        $valueOffer = Text::selectedValueOffer($page);
        if ($valueOffer == null) {
            $valueOfferBackgroundColor = 'lightgray';
            $valueOfferOppositeColor = 'gray';
        } elseif ($page->text_value_offer == 0) {
            $valueOfferBackgroundColor = 'lightgray';
            $valueOfferOppositeColor = 'gray';
            $valueOffer->text = Text::unformatText($valueOffer->text);
        } else {
            $valueOfferBackgroundColor = $page->principal_color;
            $valueOfferOppositeColor = $page->opposite_color;
            $valueOffer->text = Text::unformatText($valueOffer->text);
        }

        $about = Text::selectedAbout($page);
        if ($about) {
            $about->text = Text::unformatText($about->text);
        }

        $strengths = Text::selectedStrengths($page);
        if ($strengths) {
            foreach ($strengths as $strength) {
                $strength->text = Text::unformatText($strength->text);
            }
        }

        $products = Product::activatedProducts($page->account_id)->take(5);
        if ($products == null) {
            $shopBackgroundColor = 'lightgray';
            $shopOppositeColor = 'gray';
        } elseif ($page->shop == 0) {
            $shopBackgroundColor = 'lightgray';
            $shopOppositeColor = 'gray';
        } else {
            $shopBackgroundColor = $page->principal_color;
            $shopOppositeColor = $page->opposite_color;
        }

        //
        $templates = Page::listTemplates();
        $currentTemplate = Page::returnTemplateName($page->template);
        $states = returnStates();
        $status = Page::returnStatus();

        $formFields = Page::formFieldsEdit($page);
//dd($formFields);
        
        return view('marketing.pages.edit', compact(
                        'page',
                        'banners',
                        'marketingImages',
                        'logos',
                        'copys',
                        'biographies',
                        'biographyName',
                        'valueOffer',
                        'valueOfferBackgroundColor',
                        'valueOfferOppositeColor',
                        'products',
                        'shopBackgroundColor',
                        'shopOppositeColor',
                        'about',
                        'strengths',
//                        'text1Name',
//                        'text2Name',
                        'templates',
                        'currentTemplate',
                        'states',
                        'status',
                        'formFields',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:pages',
//                    'date_start' => 'required:tasks',
//                    'date_due' => 'required:tasks',
//                    'description' => 'required:tasks',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $page->fill($request->all());
            $page->contact_first_name = $request->has('contact_first_name') ? 1 : 0;
            $page->contact_last_name = $request->has('contact_last_name') ? 1 : 0;
            $page->contact_email = $request->has('contact_email') ? 1 : 0;
            $page->contact_phone = $request->has('contact_phone') ? 1 : 0;
            $page->contact_site = $request->has('contact_site') ? 1 : 0;
            $page->contact_address = $request->has('contact_address') ? 1 : 0;
            $page->contact_neighborhood = $request->contact_neighborhood ? 1 : 0;
            $page->contact_city = $request->has('contact_city') ? 1 : 0;
            $page->contact_state = $request->has('contact_state') ? 1 : 0;
            $page->contact_country = $request->has('contact_country') ? 1 : 0;
            $page->contact_upload_image = $request->has('contact_upload_image') ? 1 : 0;
            $page->biography_id = $request->biography_id;
            $page->authorization_contact = $request->has('authorization_contact') ? 1 : 0;
            $page->authorization_newsletter = $request->has('authorization_newsletter') ? 1 : 0;
            $page->save();

            return redirect()->route('page.edit', [$page]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page) {
        //
    }

    public function public(Page $page) {
        $states = Contact::returnStates();
        $page->with([
            'banner',
            'logo',
        ]);

        $user = User::where('account_id', $page->account_id)
                ->where('perfil', 'dono')
                ->first();

        $accountType = $page->accountType($page->account_id);

        $valueOffer = Text::selectedValueOffer($page);
        if ($valueOffer) {
            $valueOffer->text = Text::unformatText($valueOffer->text);
        }

        $about = Text::selectedAbout($page);
        if ($valueOffer) {
            $about->text = Text::unformatText($about->text);
        }

        $strengths = Text::selectedStrengths($page);
        foreach ($strengths as $strength) {
            $strength->text = Text::unformatText($strength->text);
        }
        
        $products = Product::where('account_id', $page->account_id)
                ->where('shop', 1)
                ->take(3)
                ->get();

        foreach($products as $product) {
            $product->image = Product::getImage($product);
        }
        
        return view('marketing.pages.public', compact(
                        'page',
                        'states',
                        'user',
                        'accountType',
                        'valueOffer',
                        'about',
                        'strengths',
                        'products',
        ));
    }

    public function redirect(Page $page) {
        return redirect()->route('page.public', ['page' => $page]);
    }

}
