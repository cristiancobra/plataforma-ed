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
        $journeys = Journey::filterJourneys($request);
        $status = $this->returnStatus();
        $users = User::myUsers();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $departments = Task::returnDepartments();

        return view('operational.journey.indexJourneys', compact(
                        'journeys',
                        'users',
                        'contacts',
                        'companies',
                        'status',
                        'departments',
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
        if ($journey->end == null) {
            $journey->status = 'fazendo';
        } else {
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
                ->where('status', 'fazer')
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

    // chama o método que completa a jornada e direciona para a view show
    public function completeJourney(Journey $journey) {
        Journey::completeJourney($journey);

        return redirect()->route('journey.show', compact(
                                'journey',
        ));
    }

    // chama o método que completa a JORNADA E A TAREFA da jornada  e direciona para a view show
    public function completeJourneyAndTask(Journey $journey) {
        Journey::completeJourney($journey);

        $task = Task::completeTask($journey->task);

        return redirect()->route('task.show', compact(
                                'task',
        ));
    }

    public function reportByUsers(Request $request) {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

        $annualTotal = Journey::accountHoursByYear($year);
        $monthlyAverage = $annualTotal / $pastMonths;

        $annualTotal = number_format($annualTotal / 3600, 0, ',', '.');
        $monthlyAverage = number_format($monthlyAverage / 3600, 0, ',', '.');

        $monthlyTotals = Journey::accountHoursByMonth($year);

        $users = User::myUsers();

        foreach ($users as $user) {
            $user = Journey::userHoursByMonth($year, $user);
            $user = Journey::userHoursByYear($year, $user);
        }

        $chartBackgroundColors = [
            'rgba(255, 206, 86, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(41, 221, 101, 0.2)',
            'rgba(255, 99, 132, 0.2)',
        ];

        $chartBorderColors = [
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(41, 221, 101, 1)',
            'rgba(255, 99, 132, 1)',
        ];

        return view('operational.journey.reportByUsers', compact(
                        'year',
                        'users',
                        'months',
                        'annualTotal',
                        'monthlyTotals',
                        'monthlyAverage',
                        'annualTotal',
                        'chartBackgroundColors',
                        'chartBorderColors',
        ));
    }

    public function reportByDepartments(Request $request) {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

        $annualTotal = Journey::accountHoursByYear($year);
        $monthlyAverage = $annualTotal / $pastMonths;

        $annualTotal = number_format($annualTotal / 3600, 0, ',', '.');
        $monthlyAverage = number_format($monthlyAverage / 3600, 0, ',', '.');

        $monthlyTotals = Journey::accountHoursByMonth($year);
        $departmentsNames = Task::returnDepartments();
        $departments = [];
        foreach ($departmentsNames as $department) {
            $departments[$department]['name'] = $department;
            $departments[$department]['monthlys'] = Journey::departmentHoursByMonth($year, $department);
            $departments[$department]['year'] = Journey::departmentHoursByYear($year, $department);
        }

        return view('operational.journey.reportByDepartments', compact(
                        'year',
                        'months',
                        'departments',
                        'departmentsNames',
                        'annualTotal',
                        'annualTotal',
                        'monthlyTotals',
                        'monthlyAverage',
        ));
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
