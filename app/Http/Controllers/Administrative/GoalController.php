<?php

namespace App\Http\Controllers\Administrative;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\Opportunity;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $goals = Goal::filterGoals($request);
        
                $departments = Task::returnDepartments();
                $status = Goal::returnStatus();
                $trashStatus = request()->trash;
        
        return view('administrative.goals.index', compact(
                'goals',
                'departments',
                'status',
                'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                $departments = Task::returnDepartments();
                $status = Goal::returnStatus();
        
        return view('administrative.goals.create', compact(
                'departments',
                'status',
        ));
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
                    'name' => 'required:goals',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $goal = new Goal();
            $goal->fill($request->all());
            $goal->account_id = auth()->user()->account_id;
            
            if($request->department == 'desenvolvimento') {
                $goal->goal_points = 1;
            }
            $goal->save();

            if ($request->file('image')) {
                $image = new Image();
                $image->account_id = auth()->user()->account_id;
                $image->task_id = $goal->id;
                $image->type = 'tarefa';
                $image->name = 'Imagem da meta ' . $goal->name;
                $image->status = 'disponível';
                $path = $request->file('image')->store('users_images');
                $image->path = $path;
                $image->save();
            }

            return redirect()->route('goal.show', [$goal]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        $projects = Opportunity::getProjectsOfGoal($goal->id);

        return view('administrative.goals.show', compact(
                        'goal',
                        'projects',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        $projects = Opportunity::getProjectsOfGoal($goal->id);
                        $departments = Task::returnDepartments();
                $types = Goal::returnTypes();
                $status = Goal::returnStatus();

        return view('administrative.goals.edit', compact(
                        'goal',
                        'projects',
                        'departments',
                        'types',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:goals',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $goal->department = $request->department;
            $goal->name = $request->name;
            $goal->description = $request->description;
            $goal->date_start = $request->date_start;
            $goal->date_due = $request->date_due;
            $goal->date_conclusion = $request->date_conclusion;
            $goal->type = $request->type;

//            dd($request);
            switch($goal->type) {
                case 'execução':
                    $goal->goal_points = 0;
                    break;
                case 'contatos':
                    $goal->goal_contacts = $request->goal_contacts;
                    break;
                case 'receita':
                    $goal->goal_invoices_revenues = $request->goal_invoices_revenues;
                    break;
                case 'despesa':
                    $goal->goal_invoices_expenses = $request->goal_invoices_expenses;
                    break;
                case 'entrada':
                    $goal->goal_transactions_revenues = $request->goal_transactions_revenues;
                    break;
                case 'saída':
                    $goal->goal_transactions_expenses = $request->goal_transactions_expenses;
                    break;
            }
            $goal->save();

            return redirect()->route('goal.show', [$goal]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        //
    }
    
    
    public function sendToTrash(Goal $goal) {
        $goal->trash = 1;
        $goal->save();

        return redirect()->back();
    }

    public function restoreFromTrash(Goal $goal) {
        $goal->trash = 0;
        $goal->save();

        return redirect()->back();
    }

}
