<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\SystemText;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemTextsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $systemTexts = SystemText::filterSystemTexts($request);

//        $valueOffer = Text::myValueOffer();
//        $about = Text::myAbout();
//        $strengths = Text::myStrengths();
//        $users = User::myUsers();
        $status = SystemText::returnStatus();
        $departments = Text::returnDepartments();
//        $trashStatus = request()->trash;

        return view('system/system_texts/index', compact(
                        'systemTexts',
                        'departments',
                        'status',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $departments = Text::returnDepartments();
        $status = SystemText::returnStatus();
        $types = SystemText::returnTypes();

        return view('system/system_texts/create', compact(
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
                    'name' => 'required:system_texts',
                    'title' => 'required:system_texts',
                    'text' => 'required:system_texts',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $systemText = new SystemText();
            $systemText->fill($request->all());
            $systemText->save();

            return redirect()->route('systemtext.show', [$systemText]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemText  $systemText
     * @return \Illuminate\Http\Response
     */
    public function show(SystemText $systemText) {

        return view('system/system_texts/show', compact(
                        'systemText',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemText  $systemText
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemText $systemText) {
        $departments = Text::returnDepartments();
        $status = SystemText::returnStatus();
        $types = SystemText::returnTypes();

        return view('system/system_texts/edit', compact(
                        'systemText',
                        'departments',
                        'status',
                        'types',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemText  $systemText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemText $systemText) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:system_texts',
                    'title' => 'required:system_texts',
                    'text' => 'required:system_texts',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $systemText->fill($request->all());
            $systemText->save();


            return redirect()->route('systemText.show', [$systemText]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemText  $systemText
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemText $systemText) {
        //
    }

}
