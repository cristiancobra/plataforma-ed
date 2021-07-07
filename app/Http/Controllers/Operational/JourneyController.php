<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\User;
use DateTime;
use DateInterval;

class JourneyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $journeys = $this->filterJourneys($request);
        $status = $this->returnStatus();
        $users = User::myUsers();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('operational.journey.indexJourneys', compact(
                        'journeys',
                        'users',
                        'contacts',
                        'companies',
                        'status',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $tasks = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        return view('operational.journey.createJourney', compact(
                        'users',
                        'tasks',
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
                    'date' => 'required:journeys',
                    'start' => 'required:journeys',
                    'task_id' => 'required:tasks',
                    'user_id' => 'required:tasks',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $journey = new Journey();
            $journey->fill($request->all());
            $journey->account_id = auth()->user()->account_id;

            $dateStart = new DateTime($request->date . " " . $request->start);
            $journey->start = $dateStart->format('Y-m-d H:i:s');
            $dateEnd = new DateTime($request->date . " " . $request->end);

            if ($request->end == null) {
                $journey->duration = 0;
                $journey->status = 'fazendo';
            } elseif ($dateStart < $dateEnd) {
                $journey->end = $dateEnd->format('Y-m-d H:i:s');
                $journey->duration = strtotime($journey->end) - strtotime($journey->start);
                $journey->status = 'feito';
            } elseif ($dateStart > $dateEnd) {
                $dateEnd->add(new DateInterval('P1D'));
                $journey->end = $dateEnd->format('Y-m-d H:i:s');
                $journey->duration = strtotime($journey->end) - strtotime($journey->start);
                $journey->status = 'feito';
            }
            $journey->save();
        }

        return view('operational.journey.showJourney', compact(
                        'journey',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function show(Journey $journey) {
        if($journey->end == null) {
            $journey->status = 'fazendo';
        }else{
            $journey->status = 'feito';
        }

        return view('operational.journey.showJourney', compact(
                        'journey',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function edit(Journey $journey) {
        $tasks = Task::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        return view('operational.journey.editJourney', compact(
                        'journey',
                        'tasks',
                        'users',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journey $journey) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'date' => 'required:journeys',
                    'start' => 'required:journeys',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $journey->fill($request->all());

            $dateStart = new DateTime($request->date . " " . $request->start);
            $journey->start = $dateStart->format('Y-m-d H:i:s');
            $dateEnd = new DateTime($request->date . " " . $request->end);
            if ($request->end == null) {
                $journey->duration = 0;
                $journey->status = 'fazendo';
            } elseif ($dateStart < $dateEnd) {
                $journey->end = $dateEnd->format('Y-m-d H:i:s');
                $journey->duration = strtotime($journey->end) - strtotime($journey->start);
                $journey->status = 'feito';
            } elseif ($dateStart > $dateEnd) {
                $dateEnd->add(new DateInterval('P1D'));
                $journey->end = $dateEnd->format('Y-m-d H:i:s');
                $journey->duration = strtotime($journey->end) - strtotime($journey->start);
                $journey->status = 'feito';
            }
            $journey->save();

            return view('operational.journey.showJourney', [
                'journey' => $journey,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journey $journey) {
        $journey->delete();
        return redirect()->action('Operational\\JourneyController@index');
    }

    public function filterJourneys(Request $request) {
        $journeys = Journey::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->date_start) {
                        $query->where('date', '=>', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('date', '=<', $request->date_end);
                    }
//                    if ($request->name) {
//                        $query->where('name', 'like', "%$request->name%");
//                    }
//                    if ($request->department) {
//                        $query->where('department', $request->department);
//                    }
//                    if ($request->contact_id) {
//                        $query->where('contact_id', $request->contact_id);
//                    }
//                    if ($request->company_id) {
//                        $query->where('company_id', $request->company_id);
//                    }
//                    if ($request->priority) {
//                        $query->where('priority', $request->priority);
//                    }
//                    if ($request->status == '') {
//                        // busca todos
//                    } elseif ($request->status == 'fazendo') {
//                        $query->where('status', 'fazer');
//                        $query->whereHas('journeys');
//                    } elseif ($request->status) {
//                        $query->where('status', $request->status);
//                    }
                })
                ->with(
                        'account',
                        'task.opportunity',
                        'user',
                )
                ->orderBy('DATE', 'DESC')
                ->orderBy('START_TIME', 'DESC')
                ->paginate(20);

        $journeys->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        return $journeys;
    }

    public function completeJourney(Journey $journey) {
        $dateStart = new DateTime($journey->start);
        $journey->start = $dateStart->format('Y-m-d H:i:s');
        $dateEnd = new DateTime('now');
        $journey->end = $dateEnd->format('Y-m-d H:i:s');
        $journey->duration = strtotime($journey->end) - strtotime($journey->start);
        $journey->save();

        return redirect()->route('journey.show', compact(
                        'journey',
        ));
    }

    public function monthlyReport(Request $request) {
        $months = returnMonths();

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

        // calcular horas por USUÁRIOS
        $users = User::myUsers();
//dd($users);
        $counterArray = 1;
        $counterAnnual = 1;
        foreach ($users as $user) {
            $counterMonth = 1;
            while ($counterMonth <= 12) {
                $initialDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01";
                $finalDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31";
                $monthlyUser[$counterArray] = Journey::where('user_id', $user->id)
                        ->whereBetween('date', [$initialDate, $finalDate])
                        ->sum('duration');
                $monthlyAllUsers[$counterArray] = Journey::whereHas('user', function ($query) {
                            $query->where('account_id', auth()->user()->account_id);
                        })
                        ->whereBetween('date', [$initialDate, $finalDate])
                        ->sum('duration');
                $counterMonth++;
                $counterArray++;
            }
            $annualUser[$counterAnnual] = Journey::where('user_id', $user->id)
                    ->whereBetween('date', [$year . '-01-01', $year . '-12-31'])
                    ->sum('duration');
            $counterAnnual++;
        }

        // calcular horas por DEPARTAMENTOS
        $departments = Task::returnDepartments();
        $counterArray = 1;
        $counterAnnual = 1;
        foreach ($departments as $department) {
            $counterMonth = 1;
            while ($counterMonth <= 12) {
                $initialDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-01";
                $finalDate = $year . "-" . str_pad($counterMonth, 2, "0", STR_PAD_LEFT) . "-31";
                $monthlyDepartment[$counterArray] = Journey::whereHas('task', function ($query) use ($department) {
                            $query->where('account_id', auth()->user()->account_id);
                            $query->where('department', 'LIKE', $department);
                        })
//                        ->where('user_id', auth()->user()->id)
                        ->whereBetween('date', [$initialDate, $finalDate])
                        ->sum('duration');
                $monthlyAllDepartments[$counterArray] = Journey::whereHas('task', function ($query) use ($department) {
                            $query->where('account_id', auth()->user()->account_id);
                        })
                        ->whereBetween('date', [$initialDate, $finalDate])
                        ->sum('duration');
                $counterMonth++;
                $counterArray++;
            }
            $annualDepartment[$counterAnnual] = Journey::whereHas('task', function ($query) use ($department) {
                        $query->where('account_id', auth()->user()->account_id);
                        $query->where('department', 'LIKE', $department);
                    })
                    ->whereBetween('date', [$year . '-01-01', $year . '-12-31'])
                    ->sum('duration');
            $counterAnnual++;
        }

        $annualHours = $this->companyHoursYear($year, $request->account_id);

        return view('operational.journey.reports', compact(
                        'users',
                        'months',
                        'departments',
                        'counterMonth',
                        'counterArray',
                        'monthlyUser',
                        'monthlyAllUsers',
                        'annualUser',
                        'monthlyDepartment',
                        'monthlyAllDepartments',
                        'annualDepartment',
                        'annualHours',
        ));
    }

    public function companyHoursYear($year, $account = null) {
        $annualHours = Journey::whereHas('task', function ($query) use ($account) {
                    $query->where('account_id', auth()->user()->account_id);
                })
                ->whereBetween('date', [$year . '-01-01', $year . '-12-31'])
                ->sum('duration');

        return $annualHours;
    }

    function returnStatus() {
        return $status = array(
            'fazer',
            'aguardar',
            'feito',
            'fazendo',
            'cancelado',
        );
    }

}
