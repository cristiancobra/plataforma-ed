<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Image;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Text;
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

        $logos = Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->where('type', 'logo')
                ->get();

        $templates = Page::listTemplates();

        $status = Page::returnStatus();

        return view('marketing.pages.create', compact(
                        'images',
                        'logos',
                        'templates',
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
            $page->contact_first_name = $request->has('contact_first_name') == 'on' ? 1 : 0;
            $page->contact_last_name = $request->has('contact_last_name') == 'on' ? 1 : 0;
            $page->contact_email = $request->has('contact_email') == 'on' ? 1 : 0;
            $page->contact_phone = $request->has('contact_phone') == 'on' ? 1 : 0;
            $page->contact_site = $request->has('contact_site') == 'on' ? 1 : 0;
            $page->contact_address = $request->has('contact_address') == 'on' ? 1 : 0;
            $page->contact_neighborhood = $request->has('contact_neighborhood') == 'on' ? 1 : 0;
            $page->contact_city = $request->has('contact_city') == 'on' ? 1 : 0;
            $page->contact_state = $request->has('contact_state') == 'on' ? 1 : 0;
            $page->contact_country = $request->has('contact_country') == 'on' ? 1 : 0;
            $page->contact_upload_image = $request->has('contact_upload_image') == 'on' ? 1 : 0;
            $page->authorization_contact = $request->has('authorization_contact') ? true : false;
            $page->authorization_newsletter = $request->has('authorization_newsletter') ? true : false;
            $page->save();

//            if ($request->file('image')) {
//                $image = new Image();
//                $image->account_id = auth()->user()->account_id;
//                $image->task_id = $page->id;
//                $image->type = 'tarefa';
//                $image->name = 'Imagem da tarefa ' . $page->id;
//                $image->status = 'disponível';
//                $path = $request->file('image')->store('users_images');
//                $image->path = $path;
//                $image->save();
//            }

            return redirect()->route('index.show', compact(
                                    'page',
            ));
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
//                    dd($page->with('text'));
        $banners = Image::myBanners();

        $logos = Image::where('account_id', auth()->user()->account_id)
                ->where('status', 'disponível')
                ->where('type', 'logo')
                ->get();

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

        $valueOffer = Text::myValueOffer();
        $about = Text::myAbout();
        $strengths = Text::myStrengths();
//        dd($strengths);
//        $text1Name = Text::find($page->text1)
//                ->pluck('name');
//        
//        $text2Name = Text::find($page->text2)
//                ->pluck('name');

        $templates = Page::listTemplates();
        $currentTemplate = Page::returnTemplateName($page->template);
        $states = returnStates();
        $status = Page::returnStatus();

        $formFields = Page::formFields($page);

        return view('marketing.pages.edit', compact(
                        'page',
                        'banners',
                        'logos',
                        'copys',
                        'biographies',
                        'biographyName',
                        'valueOffer',
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
            $page->contact_first_name = $request->has('contact_first_name') == 'on' ? 1 : 0;
            $page->contact_last_name = $request->has('contact_last_name') == 'on' ? 1 : 0;
            $page->contact_email = $request->has('contact_email') == 'on' ? 1 : 0;
            $page->contact_phone = $request->has('contact_phone') == 'on' ? 1 : 0;
            $page->contact_site = $request->has('contact_site') == 'on' ? 1 : 0;
            $page->contact_address = $request->has('contact_address') == 'on' ? 1 : 0;
            $page->contact_neighborhood = $request->has('contact_neighborhood') == 'on' ? 1 : 0;
            $page->contact_city = $request->has('contact_city') == 'on' ? 1 : 0;
            $page->contact_state = $request->has('contact_state') == 'on' ? 1 : 0;
            $page->contact_country = $request->has('contact_country') == 'on' ? 1 : 0;
            $page->contact_upload_image = $request->has('contact_upload_image') == 'on' ? 1 : 0;
            $page->biography_id = $request->biography_id;

            $page->authorization_contact = $request->has('authorization_contact') ? true : false;
            $page->authorization_newsletter = $request->has('authorization_newsletter') ? true : false;
            $page->save();

//            if ($request->file('contact_upload_image')) {
//                $image = new Image();
//                $image->account_id = $page->account_id;
//                $image->type = 'upload_cliente';
//                $image->name = 'Imagem enviada pelo cliente ';
//                $image->status = 'revisar';
//                $path = $request->file('contact_upload_image')->store('customers_images');
//                $image->path = $path;
//                $image->save();
//            }

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

        $about = Text::selectedAbout($page);
        $strengths = Text::selectedStrengths($page);

        return view('marketing.pages.public', compact(
                        'page',
                        'states',
                        'user',
                        'about',
                        'strengths',
        ));
    }
    
    public function redirect(Page $page) {
        return redirect()->route('page.public', ['slug' => $page->slug]);
    }

}
