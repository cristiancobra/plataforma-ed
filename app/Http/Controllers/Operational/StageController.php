<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Goal;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:stages',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $stage = new Stage();
            $stage->fill($request->all());
            $stage->account_id = auth()->user()->account_id;
            $stage->save();
//
//            if ($request->file('image')) {
//                $image = new Image();
//                $image->account_id = auth()->user()->account_id;
//                $image->task_id = $stage->id;
//                $image->type = 'tarefa';
//                $image->name = 'Imagem da meta ' . $stage->name;
//                $image->status = 'disponível';
//                $path = $request->file('image')->store('users_images');
//                $image->path = $path;
//                $image->save();
//            }

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Stage $stage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function edit(Stage $stage)
    {
//        dd($stage);
        $title = 'ETAPAS';
        $status = Stage::returnStatus();
//
//        $projects = Project::where('account_id', auth()->user()->account_id)
//                ->orderBy('NAME', 'ASC')
//                ->get();
//
        $users = User::myUsers();
//
//        $goals = Goal::openGoals();

//        $contacts = Contact::where('account_id', auth()->user()->account_id)
//                ->orderBy('NAME', 'ASC')
//                ->get();

        return view('operational.stages.edit', compact(
                        'title',
                        'stage',
//                        'project',
                        'users',
//                        'goals',
//                        'contacts',
//                        'projects',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stage $stage)
    {
        $stage->fill($request->all());
        $stage->save();

        return redirect()->route('project.show', [$stage->project_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        //
    }
}
