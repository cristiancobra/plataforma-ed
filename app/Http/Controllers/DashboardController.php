<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;
use DB;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Shop;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;

/**
 * Classe responsável por criar os dashboards (painéis) dos departamentos
 */
class DashboardController extends Controller {
    
        public function development() {
        $nada = 0;
        
        return view('dashboards.development', compact(
                        'nada',
        ));
    }

    public function operational() {
        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $teamTasks = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->where('trash', '!=',  1)
                ->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
                ->get();

//        $teamTasksPending = $teamTasks->where('status', 'fazer');
        $teamTasksCount = $teamTasks->count();

        $teamTasksEmergencies = $teamTasks->where('priority', 'emergência');
        $teamTasksEmergenciesCount = $teamTasksEmergencies->count();

        $teamTasksLates = $teamTasks->where('date_due', '<', date('Y-m-d'));
        $teamTasksLatesCount = $teamTasksLates->count();
        
        $myTasks = $teamTasks->where('user_id', auth()->user()->id);
        $myTasksLimited = $myTasks->take(4);
        $myTasksCount = $myTasks->count();
        
            $users = User::myUsers();
            foreach($users as $user) {
                $user->emergencies = Task::countUserEmergencies($user);
                $user->high = Task::countUserHigh($user);
                $user->medium = Task::countUserMedium($user);
                $user->low = Task::countUserLow($user);
                $user->tasks = Task::countUserTasks($user);
                $user->lates = Task::countUserTasksLates($user);
                $user->lastJourney = Journey::userLastJourney($user);
                $user->lastTask = Task::userLastTask($user);
            }
//        
        $myTasksEmergencies = $myTasks->where('priority', 'emergência');
//        $myTasksEmergenciesCount = $myTasksEmergencies->count();
//        
//        $myTasksHigh = $myTasks->where('priority', 'alta');
//        $myTasksHighCount = $myTasksHigh->count();
        
        $myTasksMedium = $myTasks->where('priority', 'média');
        $myTasksMediumCount = $myTasksMedium->count();
        
        $myTasksLow = $myTasks->where('priority', 'baixa');
        $myTasksLowCount = $myTasksLow->count();

        $myTasksLate = $myTasks->where('date_due', '<', date('Y-m-d'));
        $myTasksLateCount = $myTasksLate->count();

//        $myTasksEmergenciesUnsorted = $myTasks->where('priority', 'emergência')->take(5);
//        $myTasksEmergencies =  $myTasksEmergenciesUnsorted->sortBy('date_due');

//        $myTasksEmergenciesAmount = $myTasksEmergencies->count();
        
        $myTasksTodayUnsorted = $myTasks->whereBetween('date_due', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->take(3);
        $myTasksToday =  $myTasksTodayUnsorted->sortBy('date_due');

            $openJourney = Journey::myOpenJourney();
            $myLastJourney = Journey::myLastJourney();

            $journeys = Journey::where('user_id', auth()->user()->id)
                    ->get();
            
            $lastJourneys = $journeys->sortByDesc('start')->take(5);
//            dd($lastJourneys);

            $hoursMonthly = Journey::where('user_id', auth()->user()->id)
                    ->whereBetween('start', [$monthStart, $monthEnd])
                    ->sum('duration');
            
            $hoursToday = Journey::where('user_id', auth()->user()->id)
                    ->whereBetween('start', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
                    ->sum('duration');
            
       
            
            foreach($users as $user) {
                $openJourney = Journey::openJourney($user);
                if($openJourney != null) {
                $user['journeyName'] = $openJourney->task->name;
                $user['taskId'] = $openJourney->task->id;
                          $user['color'] = 'white';
                          $user['backgroundColor'] = null;
            } else {
                $user['journeyName'] = 'ZZZzz';
                $user['taskId'] = null;
                $user['color'] = 'gray';
                $user['backgroundColor'] = 'lightgray';
            }
            }

        return view('dashboards/operational', compact(
                        'month',
                        'monthStart',
                        'monthEnd',
                        'month',
                        'hoursMonthly',
                        'hoursToday',
                        'teamTasks',
                        'teamTasksCount',
                        'teamTasksEmergencies',
                        'teamTasksEmergenciesCount',
                        'teamTasksLatesCount',
                        'myTasksLimited',
//                        'myTasksHigh',
//                        'myTasksHighCount',
                        'myTasksMedium',
                        'myTasksMediumCount',
                        'myTasksCount',
                        'myTasksLow',
                        'myTasksLowCount',
                        'myTasksLateCount',
//                        'myTasksEmergencies',
//                        'myTasksEmergenciesCount',
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
        
         $transactions = Transaction::where('account_id', auth()->user()->account_id)
                 ->where('trash', '!=', 1)
                 ->take(6)
                ->orderBy('pay_day', 'DESC')
                 ->get();
        
         $dateDue = new DateTime('now');
         $dateDue->add(new DateInterval('P2D'));
         $dateDue = $dateDue->format('Y-m-d');
        
         $dateLimit = new DateTime('now');
         $dateLimit->sub(new DateInterval('P1M'));
         $dateLimit = $dateLimit->format('Y-m-d');
//       dd($dateLimit);
         $invoices = Invoice::where('account_id', auth()->user()->account_id)
                 ->where('trash', '!=', 1)
                 ->where('status', 'aprovada')
//                 ->where('pay_day', '>', $dateDue)
                 ->whereBetween('pay_day', [$dateLimit, $dateDue])
//                 ->whereBetween('pay_day', ['2021-10-24', '2021-12-22'])
                 ->take(6)
                ->orderBy('pay_day', 'ASC')
                 ->get();
         
//                 $invoices = Invoice::filterInvoices($request);
//        
//                foreach ($invoices as $invoice) {
//            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
//                    ->where('trash', '!=', 1)
//                    ->sum('value');
//            if ($invoice->totalPrice == $invoice->paid) {
//                $invoice->status = 'paga';
//            } elseif ($invoice->totalPrice > $invoice->paid AND $invoice->paid > 0) {
//                $invoice->status = 'parcial';
//            } elseif ($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d')) {
//                $invoice->status = 'atrasada';
//            }
//
//            $invoice->balance = $invoice->totalPrice - $invoice->paid;

//            $invoicesTotal += $invoice->totalPrice;
//            $proposal->balance += $invoice->balance;
//        }

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
                        'transactions',
                        'invoices',
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

        $shop = Shop::where('account_id', auth()->user()->account_id)
                ->with('banner')
                ->first();
//dd($shop);

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
                        'shop',
        ));
    }

}
