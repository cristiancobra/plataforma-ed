<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use App\Models\Page;
use App\Models\Text;
use App\Models\User;

class TextController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $texts = Text::filterTexts($request);

        $valueOffer = Text::myValueOffer();
        $about = Text::myAbout();
        $strengths = Text::myStrengths();
//dd($strengths);
        $users = User::myUsers();
        $status = Text::returnStatus();
        $departments = Text::returnDepartments();
        $trashStatus = request()->trash;

        return view('libraries/texts/index', compact(
                        'texts',
                        'users',
                        'status',
                        'departments',
                        'trashStatus',
                        'valueOffer',
                        'about',
                        'strengths',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $departments = Text::returnDepartments();
        $status = Text::returnStatus();
        $types = Text::returnTypes();

        // campos enviados por request
//        $taskName = $request->task_name;
//        $opportunityId = $request->opportunity_id;
//        $opportunityName = $request->opportunity_name;
//        $opportunityContactName = $request->contact_name;
//        $opportunityContactId = $request->contact_id;
//        $taskAccountName = $request->account_name;
//        $taskAccountId = $request->account_id;
//        $department = 'vendas';

        return view('libraries/texts/create', compact(
                        'departments',
                        'status',
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
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:texts',
                    'title' => 'required:texts',
                    'text' => 'required:texts',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $text = new Text();
            $text->fill($request->all());
            $text->account_id = auth()->user()->account_id;
            $text->user_id = auth()->user()->id;
            $text->save();

            if ($request->file('image')) {
                $image = new Image();
                $image->account_id = auth()->user()->account_id;
                $image->task_id = $text->id;
                $image->type = 'tarefa';
                $image->name = 'Imagem do texto ' . $text->id;
                $image->status = 'disponível';
                $path = $request->file('image')->store('users_images');
                $image->path = $path;
                $image->save();
            }

            return redirect()->route('text.show', [$text]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\texts  $text
     * @return \Illuminate\Http\Response
     */
    public function show(text $text) {

        switch ($text->type) {
            case 'apresentação da empresa':
                $pages = Page::where('account_id', auth()->user()->account_id)
                        ->where('company_about', 1)
                        ->get();
                break;
            case 'proposta de valor':
                $pages = Page::where('account_id', auth()->user()->account_id)
                        ->where('text_value_offer', 1)
                        ->get();
                break;
            case 'força':
                $pages = Page::where('account_id', auth()->user()->account_id)
                        ->where('company_strengths', 1)
                        ->get();
                break;
            default:
                $pages = null;
        }
//        dd($pages);
        return view('libraries/texts/show', compact(
                        'text',
                        'pages',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\texts  $text
     * @return \Illuminate\Http\Response
     */
    public function edit(text $text) {
        $users = User::myUsers();
        $departments = Text::returnDepartments();
        $status = Text::returnStatus();
        $types = Text::returnTypes();

        return view('libraries/texts/edit', compact(
                        'users',
                        'text',
                        'departments',
                        'status',
                        'types',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, text $text) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:texts',
                    'title' => 'required:texts',
                    'text' => 'required:texts',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $text->fill($request->all());
            $text->save();

            if ($request->file('image')) {
                $image = new Image();
                $image->account_id = auth()->user()->account_id;
                $image->task_id = $text->id;
                $image->type = 'tarefa';
                $image->name = 'Imagem da tarefa ' . $text->id;
                $image->status = 'disponível';
                $path = $request->file('image')->store('users_images');
                $image->path = $path;
                $image->save();
            }

            return redirect()->route('text.show', [$text]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
