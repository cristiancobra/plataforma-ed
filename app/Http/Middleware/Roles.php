<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class Roles {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

//  Redireciona usuário para tela de login se não estiver logado
        if (Auth::user() == false) {
            return redirect('login');
        }
                
        $user = Auth::user();
        $account = Account::find($user->account_id);
        $today = date('Y-m-d');

        if ($account->due_date < $today) {
            return response()->view('administrative.accounts.allow');
        }
        
        if ($user->perfil == 'super administrador') {
            $role = "superadmin";
        } elseif ($user->perfil == 'dono') {
            $role = "dono";
        } elseif ($user->perfil == 'administrador') {
            $role = "administrator";
        } elseif ($user->perfil == 'funcionario') {
            $role = "employee";
        } elseif ($user->perfil == 'cliente') {
            $role = "customer";
        } else {
            return redirect('painel');
        }

//        Verifica se o usuário tem logo e cores da empresa
//        
//            $empresaDigital = Account::find(1);
//
//            if (auth()->user() == true AND auth()->user()->account->image) {
//                $logo = auth()->user()->account->image->path;
//            } else {
//                $logo = $empresaDigital->image->path;
//            }
//
//            if (auth()->user() == true AND auth()->user()->account->principal_color) {
//                $principalColor = auth()->user()->account->principal_color;
//            } else {
//                $principalColor = $empresaDigital->principal_color;
//            }
//
//            if (auth()->user() == true AND auth()->user()->account->complementary_color) {
//                $complementaryColor = auth()->user()->account->complementary_color;
//            } else {
//                $complementaryColor = $empresaDigital->complementary_color;
//            }
//
//            if (auth()->user() == true AND auth()->user()->account->opposite_color) {
//                $oppositeColor = auth()->user()->account->opposite_color;
//            } else {
//                $oppositeColor = $empresaDigital->opposite_color;
//            }
//   dd($request->route('account'));
//        dd($request->route()->getName());
        switch ($request->route()->getName()) {
            case 'account.show':
                if ($request->route('account')->id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'account.edit':
                if ($request->route('account')->id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'user.show':
                if ($request->route('user')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'user.edit':
                if ($request->route('user')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'company.show':
                if ($request->route('company')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'planning.show':
                if ($request->route('planning')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'planning.edit':
                if ($request->route('planning')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'invoice.show':
                if ($request->route('invoice')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'invoice.edit':
                if ($request->route('invoice')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'transaction.show':
                if ($request->route('transaction')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'transaction.edit':
                if ($request->route('transaction')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'product.show':
                if ($request->route('product')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'product.edit':
                if ($request->route('product')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'bankAccount.show':
                if ($request->route('bankAccount')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'bankAccount.edit':
                if ($request->route('bankAccount')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'socialmedia.show':
                if ($request->route('socialmedia')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'socialmedia.edit':
                if ($request->route('socialmedia')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'page.show':
                if ($request->route('page')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'page.edit':
                if ($request->route('page')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'report.show':
                if ($request->route('report')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'report.edit':
                if ($request->route('report')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'image.show':
                if ($request->route('image')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'image.edit':
                if ($request->route('image')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contact.show':
                if ($request->route('contact')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contact.edit':
                if ($request->route('contact')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'opportunity.show':
                if ($request->route('opportunity')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'opportunity.edit':
                if ($request->route('opportunity')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'proposal.show':
                if ($request->route('proposal')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'proposal.edit':
                if ($request->route('proposal')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contract.show':
                if ($request->route('contract')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contract.edit':
                if ($request->route('contract')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contractTemplate.show':
                if ($request->route('contractTemplate')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'contractTemplate.edit':
                if ($request->route('contractTemplate')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'task.show':
                if ($request->route('task')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'task.edit':
                if ($request->route('task')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'journey.show':
                if ($request->route('journey')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            case 'journey.edit':
                if ($request->route('journey')->account_id != auth()->user()->account_id) {
                    $permission = false;
                } else {
                    $permission = true;
                }
                break;
            default:
                $permission = true;
                break;
        }

        if ($permission == false) {
            abort(403);
        }

// verifica se o usuário tem permissão para acessar a rota
//        if ($request->route('account')) {
//            $account = $request->route('account');
//            $accountId = $account->id;
//        } else {
//            $accountId = auth()->user()->account_id;
//        }
//
//        if ($accountId != auth()->user()->account_id) {
//            abort(403);
//        }
//        Adiciona as variáveis no request e dá proseguimento
        $request->merge([
            'role' => $role,
//            'logo' => $logo,
//            'principalColor' => $principalColor,
//            'complementaryColor' => $complementaryColor,
//            'oppositeColor' => $oppositeColor,
        ]);

        return $next($request);
    }

}
