<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;

/**
 * Classe responsável por criar os dashboards (painéis) dos departamentos
 */
class DashboardController extends Controller {

    public function operational() {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $teamTasks = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->where('trash', '!=',  1)
                ->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
                ->get();

        $teamTasksPending = $teamTasks->where('status', 'fazer');
        $teamTasksPendingCount = $teamTasksPending->count();
        
        $myTasks = $teamTasks->where('user_id', auth()->user()->id);
        $myTasksLimited = $myTasks->take(4);
        $myTasksCount = $myTasks->count();
        
        $myTasksHigh = $myTasks->where('priority', 'alta');
        $myTasksHighCount = $myTasksHigh->count();
        
        $myTasksMedium = $myTasks->where('priority', 'média');
        $myTasksMediumCount = $myTasksMedium->count();
        
        $myTasksLow = $myTasks->where('priority', 'baixa');
        $myTasksLowCount = $myTasksLow->count();

        $myTasksLate = $myTasks->where('date_due', '<', date('Y-m-d'));
        $myTasksLateCount = $myTasksLate->count();

        $myTasksEmergenciesUnsorted = $myTasks->where('priority', 'emergência')->take(5);
        $myTasksEmergencies =  $myTasksEmergenciesUnsorted->sortBy('date_due');

        $myTasksEmergenciesAmount = $myTasksEmergencies->count();
        
        $myTasksTodayUnsorted = $myTasks->whereBetween('date_due', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->take(3);
        $myTasksToday =  $myTasksTodayUnsorted->sortBy('date_due');

            $openJourney = Journey::myOpenJourney();
            $myLastJourney = Journey::myLastJourney();

            $journeys = Journey::where('user_id', auth()->user()->id)
                    ->get();
            
            $lastJourneys = $journeys->sortByDesc('start')->take(5);

            $hoursMonthly = Journey::where('user_id', auth()->user()->id)
                    ->whereBetween('start', [$monthStart, $monthEnd])
                    ->sum('duration');
            
            $hoursToday = Journey::where('user_id', auth()->user()->id)
                    ->whereBetween('start', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
                    ->sum('duration');
            
       
            $users = User::myUsers();
            
            foreach($users as $user) {
                $openJourney = Journey::openJourney($user);
                if($openJourney != null) {
                $user['journeyName'] = $openJourney->task->name;
                $user['taskId'] = $openJourney->task->id;
            }
            }

        return view('dashboards/operational', compact(
                        'month',
                        'monthStart',
                        'monthEnd',
                        'month',
                        'hoursMonthly',
                        'hoursToday',
                        'teamTasksPending',
                        'teamTasksPendingCount',
                        'myTasksLimited',
                        'myTasksHigh',
                        'myTasksHighCount',
                        'myTasksMedium',
                        'myTasksMediumCount',
                        'myTasksCount',
                        'myTasksLow',
                        'myTasksLowCount',
                        'myTasksLateCount',
                        'myTasksEmergencies',
                        'myTasksEmergenciesAmount',
                        'myTasksToday',
                        'lastJourneys',
                        'myLastJourney',
                        'openJourney',
                        'users',
        ));
    }

    public function financial() {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $revenueMonthly = Transaction::where('account_id', auth()->user()->account_id)
                ->where('type', 'crédito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedRevenueMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('totalPrice');

        $expenseMonthly = Transaction::where('account_id', auth()->user()->account_id)
                ->where('type', 'débito')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('value');

        $estimatedExpenseMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'despesa')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('totalPrice');

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->get();

        foreach ($bankAccounts as $key => $bankAccount) {
            $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
//                    ->where('type', 'crédito')
                    ->sum('value');

            $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
        }

        return view('dashboards.financial', compact(
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
                        'bankAccounts',
        ));
    }

    public function marketing() {
        $nada = 0;
        
        return view('dashboards.marketing', compact(
                        'nada',
        ));
    }
    
    public function sales() {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

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

        $opportunitiesWon = Opportunity::countOpportunitiesWonWeek();
        $opportunitiesLost = Opportunity::countOpportunitiesLostWeek();
        $opportunitiesNews = Opportunity::getOpportunitiesPresentations();
        
        $contacts = [
            $contactsSuspects = Contact::countSuspects(),
            $contactsProspects = Contact::countProspects(),
            $contactsQualified = Contact::countQualified(),
        ];

        $contactsNewsTotal = Contact::countNewsContactsWeek();
        $contactsNews = Contact::getNewsContactsWeek();

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



        return view('dashboards.sales', compact(
                        'contacts',
                        'contactsNews',
                        'contactsNewsTotal',
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
                        'opportunitiesNews',
        ));
    }

}
