<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index(Request $request) {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

// SE FOR ADMINISTRADOR
        if ($request['role'] === "administrator" OR $request['role'] === "superadmin" OR $request['role'] === "dono") {
            $tasks = Task::where('account_id', auth()->user()->account_id)
                    ->get();

            $tasks_pending = $tasks
                    ->where('status', 'fazendo', 'fazer')
                    ->count();

            $journeys = Journey::where('account_id', auth()->user()->account_id)
                    ->get();

            $users = User::myUsers();

            foreach ($users as $user) {
                $user->hoursMonthly = Journey::where('user_id', $user->id)
                        ->whereBetween('date', [$monthStart, $monthEnd])
                        ->sum('duration');
                $user->hoursToday = Journey::where('user_id', $user->id)
                        ->where('date', date('Y-m-d'))
                        ->sum('duration');
            }

            $revenueMonthly = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('type', 'crédito')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('value');

            $estimatedRevenueMonthly = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('type', 'receita')
                    ->where('status', 'aprovada')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('installment_value');

            $expenseMonthly = Transaction::where('account_id', auth()->user()->account_id)
                    ->where('type', 'débito')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('value');

            $estimatedExpenseMonthly = Invoice::where('account_id', auth()->user()->account_id)
                    ->where('type', 'despesa')
                    ->where('status', 'aprovada')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('installment_value');

            $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                    ->get();

            foreach ($bankAccounts as $key => $bankAccount) {
                $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
//                    ->where('type', 'crédito')
                        ->sum('value');

                $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
            }

            $view = 'dashboards/administratorDashboard';

            $departments = "";
            $opportunitiesWon = '';

            $opportunitiesLost = '';

            // SE FOR FUNCIONÁRIO
        } elseif ($request['role'] === "employee") {
            $tasks = Task::where('user_id', Auth::user()->id)
                    ->get();

            $tasks_pending = $tasks
                    ->where('status', 'fazendo', 'fazer')
                    ->where('date_due', '<=', date('Y-m-d'))
                    ->count();

            $journeys = Journey::where('user_id', Auth::user()->id)
                    ->get();

            $users = "";
            $tasks_my = "";
            $revenueMonthly = null;
            $estimatedRevenueMonthly = null;
            $expenseMonthly = null;
            $estimatedExpenseMonthly = null;
            $bankAccounts = null;

            $view = 'dashboards/employeeDashboard';
        }

// PARTE COMUM DO CÓDIGO PARA ADMINISTRADOR E FUNCIONÁRIO
        $teamTasksPending = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->get();

        $myTasksEmergencyAmount = $teamTasksPending->where('user_id', auth()->user()->id)
                ->where('priority', 'emergência')
                ->count();

//        $tasksDone = $tasks
//                ->where('status', 'feito')
//                ->whereBetween('date_conclusion', [$monthStart, $monthEnd])
//                ->count();

        $tasks_my = $tasks
                ->whereIn('status', ['fazendo', 'fazer'])
                ->where('user_id', Auth::user()->id)
                ->count();

        // opportunities stages
        $opportunities = [
            $opportunitiesProspecting = Opportunity::countProspectings(),
            $opportunitiesPresentation = Opportunity::countPresentations(),
            $opportunitiesProposal = Opportunity::countProposals(),
            $opportunitiesContract = Opportunity::countContracts(),
            $opportunitiesBill = Opportunity::countBills(),
            $opportunitiesProduction = Opportunity::countProductions(),
            $opportunitiesConcluded = Opportunity::countCompletes(),
        ];

        $contacts = [
            $contactsSuspects = Contact::countSuspects(),
            $contactsProspects = Contact::countProspects(),
            $contactsQualified = Contact::countQualified(),
        ];

        $contactsNewsTotal = Contact::countNewsContactsWeek();
        $contactsNews = Contact::getNewsContactsWeek();
        $opportunitiesWon = Opportunity::countOpportunitiesWonWeek();
        $opportunitiesLost = Opportunity::countOpportunitiesLostWeek();

        $departments = Task::returnDepartments();

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
                        'monthStart',
                        'monthEnd',
                        'month',
                        'contacts',
                        'contactsNews',
                        'contactsNewsTotal',
                        'users',
                        'myTasksEmergencyAmount',
                        'tasks_pending',
                        'tasks_my',
                        'opportunities',
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
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
                        'bankAccounts',
        ));
    }

}
