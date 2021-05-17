<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Task;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index(Request $request) {
        $accountsId = userAccounts();

        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        if ($request['role'] === "administrator" OR $request['role'] === "superadmin" OR $request['role'] === "dono") {
            $tasks = Task::whereIn('account_id', $accountsId)
                    ->get();

            $tasks_pending = $tasks
                    ->where('status', 'fazendo', 'fazer')
                    ->count();

            $opportunities = Opportunity::whereIn('account_id', $accountsId)
                    ->get();

            $journeys = Journey::whereIn('account_id', $accountsId)
                    ->get();

            $users = User::whereHas('accounts', function ($query) use ($accountsId) {
                        $query->whereIn('account_id', $accountsId);
                    })
                    ->orderBy('ID', 'ASC')
                    ->get();

            foreach ($users as $user) {
                $user->hoursMonthly = Journey::where('user_id', $user->id)
                        ->whereBetween('date', [$monthStart, $monthEnd])
                        ->sum('duration');
                $user->hoursToday = Journey::where('user_id', $user->id)
                        ->where('date', date('Y-m-d'))
                        ->sum('duration');
            }

            $view = 'dashboards/administratorDashboard';

            $departments = "";
        } elseif ($request['role'] === "employee") {
            $tasks = Task::where('user_id', Auth::user()->id)
                    ->get();

            $tasks_pending = $tasks
                    ->where('status', 'fazendo', 'fazer')
                    ->where('date_due', '<=', date('Y-m-d'))
                    ->count();

            $opportunities = Opportunity::where('user_id', Auth::user()->id)
                    ->get();

            $journeys = Journey::where('user_id', Auth::user()->id)
                    ->get();

            $users = "";
            $tasks_my = "";

            $view = 'dashboards/employeeDashboard';
        }

        $tasksDone = $tasks
                ->where('status', 'feito')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $tasks_my = $tasks
                ->whereIn('status', ['fazendo', 'fazer'])
                ->where('user_id', Auth::user()->id)
                ->count();

        // opportunities stages
        $opportunitiesProspecting = $opportunities
                ->where('stage', 'prospecção')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesPresentation = $opportunities
                ->where('stage', 'apresentação')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesProposal = $opportunities
                ->where('stage', 'proposta')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesContract = $opportunities
                ->where('stage', 'contrato')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesBill = $opportunities
                ->where('stage', 'cobrança')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesProduction = $opportunities
                ->where('stage', 'produção')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesConcluded = $opportunities
                ->where('stage', 'concluída')
                ->count();

// opportunities status
        $opportunitiesWon = $opportunities
                ->where('status', 'ganhamos')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $opportunitiesLost = $opportunities
                ->where('status', 'perdemos')
                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
                ->count();

        $departments = returnDepartments();

        foreach ($departments as $department) {
            $departmentsMonthly[$department] = Journey::whereHas('task', function ($query) use ($department) {
                        $query->where('department', $department);
                    })
                    ->where('user_id', Auth::user()->id)
                    ->whereBetween('date', [$monthStart, $monthEnd])
                    ->sum('duration');

            $departmentsToday[$department] = Journey::whereHas('task', function ($query) use ($department) {
                        $query->where('department', $department);
                    })
                    ->where('user_id', Auth::user()->id)
                    ->where('date', date('Y-m-d'))
                    ->sum('duration');
        }

        return view($view, compact(
                        'month',
                        'users',
                        'tasksDone',
                        'tasks_pending',
                        'tasks_my',
                        'opportunitiesProspecting',
                        'opportunitiesPresentation',
                        'opportunitiesProposal',
                        'opportunitiesContract',
                        'opportunitiesBill',
                        'opportunitiesProduction',
                        'opportunitiesConcluded',
                        'opportunitiesWon',
                        'opportunitiesLost',
                        'departments',
                        'departmentsMonthly',
                        'departmentsToday',
        ));
    }

}
