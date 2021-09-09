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

    public function operational() {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $teamTasks = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->get();

        $teamTasksPending = $teamTasks->where('status', 'fazer');
        $teamTasksPendingCount = $teamTasksPending->count();
        
        $myTasks = $teamTasks->where('user_id', auth()->user()->id);
        $myTasksCount = $myTasks->count();

        $myTasksEmergenciesUnsorted = $myTasks->where('priority', 'emergência')->take(5);
        $myTasksEmergencies =  $myTasksEmergenciesUnsorted->sortBy('date_due');

        $myTasksEmergenciesAmount = $myTasksEmergencies->count();
        
        $myTasksTodayUnsorted = $teamTasks->whereBetween('date_due', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->take(3);
        $myTasksToday =  $myTasksTodayUnsorted->sortBy('date_due');


            $journeys = Journey::where('user_id', auth()->user()->id)
                    ->get();
            
            $lastJourneys = $journeys->sortByDesc('date')->take(3);

            $hoursMonthly = Journey::where('user_id', auth()->user()->id)
                    ->whereBetween('date', [$monthStart, $monthEnd])
                    ->sum('duration');
            
            $hoursToday = Journey::where('user_id', auth()->user()->id)
                    ->where('date', date('Y-m-d'))
                    ->sum('duration');
       

        return view('dashboards/operational', compact(
                        'month',
                        'monthStart',
                        'monthEnd',
                        'month',
                        'hoursMonthly',
                        'hoursToday',
                        'teamTasksPending',
                        'teamTasksPendingCount',
                        'myTasksCount',
                        'myTasksEmergencies',
                        'myTasksEmergenciesAmount',
                        'myTasksToday',
                        'lastJourneys',
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
