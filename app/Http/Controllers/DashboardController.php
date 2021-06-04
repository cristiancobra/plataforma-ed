<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index(Request $request) {
        $accountsId = userAccounts();

        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');
        
// SE FOR ADMINISTRADOR
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

            $revenueMonthly = Transaction::whereIn('account_id', userAccounts())
                    ->where('type', 'crédito')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('value');

            $estimatedRevenueMonthly = Invoice::whereIn('account_id', userAccounts())
                    ->where('type', 'receita')
                    ->where('status', 'aprovada')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('installment_value');

            $expenseMonthly = Transaction::whereIn('account_id', userAccounts())
                    ->where('type', 'débito')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('value');

            $estimatedExpenseMonthly = Invoice::whereIn('account_id', userAccounts())
                    ->where('type', 'despesa')
                    ->where('status', 'aprovada')
                    ->whereBetween('pay_day', [$monthStart, $monthEnd])
                    ->sum('installment_value');

            $bankAccounts = BankAccount::whereIn('account_id', userAccounts())
                    ->get();

            foreach ($bankAccounts as $key => $bankAccount) {
                $subTotal[$key] = Transaction::where('bank_account_id', $bankAccount->id)
//                    ->where('type', 'crédito')
                        ->sum('value');

                $bankAccount->balance = $bankAccount->opening_balance + $subTotal[$key];
            }

            $view = 'dashboards/administratorDashboard';

            $departments = "";
            
            // SE FOR FUNCIONÁRIO
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
            $revenueMonthly = null;
            $estimatedRevenueMonthly = null;
            $expenseMonthly = null;
            $estimatedExpenseMonthly = null;
            $bankAccounts = null;

            $view = 'dashboards/employeeDashboard';
        }
        
// PARTE COMUM DO CÓDIGO PARA ADMINISTRADOR E FUNCIONÁRIO
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

// OPORTUNIDADES status
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
                        'monthStart',
                        'monthEnd',
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
                        'revenueMonthly',
                        'estimatedRevenueMonthly',
                        'expenseMonthly',
                        'estimatedExpenseMonthly',
                        'bankAccounts',
        ));
    }

}
