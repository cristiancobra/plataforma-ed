<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Account;
use App\Models\Journey;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $accounts = Account::whereHas('users', function ($query) use ($request) {
                    if ($request['role'] === "superadmin") {
                        $query->where('users.id', '>', 0);
                    } elseif ($request['role'] === "administrator" OR $request['role'] === "employee") {
                        $query->where('users.id', Auth::user()->id);
                    }
                })
                ->get();

        $accountsId = $accounts->pluck('id');

        $users = User::with('contact')
                ->whereHas('accounts', function ($query) use ($accountsId, $request) {
                    if ($request['role'] === "superadmin") {
                        $query->where('accounts.id', '>', 0);
                    } elseif ($request['role'] === "administrator" OR $request['role'] === "employee") {
                        $query->whereIn('accounts.id', $accountsId);
                    }
                    if (isset($request->account_id)) {
                        $query->where('account_id', '=', $request->account_id);
                    } else {
                        $query->where('accounts.id', '>', 0);
                    }
                })
                ->whereHas('contact', function ($query) use ($request) {
                    if (!isset($request->contact_name)) {
                        $query->where('contacts.name', 'like', "%$request->user_name%");
                    }
                })
                ->paginate(20);

        $users->appends([
            'name' => $request->name,
            'account_id' => $request->account_id,
        ]);

        $total = $users->total();

        return view('users.indexUsers', compact(
                        'users',
                        'accounts',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
            $accounts = Account::whereIn('id', userAccounts())
                    ->orderBy('ID', 'ASC')
                    ->get();
            
            $accountsChecked = Account::whereHas('users', function ($query) {
                    $query->where('users.id', Auth()->user()->id);
                })
                ->pluck('id')
                ->toArray();

            $contacts = Contact::whereIn('account_id', userAccounts())
                    ->orderBy('ID', 'ASC')
                    ->get();

            return view('users.create', compact(
                'accounts',
                'accountsChecked',
                'contacts',
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $userAuth = Auth::user();

        $user = new User();
        $user->contact_id = $request->contact_id;
        $user->perfil = $request->perfil;
        $user->email = $request->email;
        $user->default_password = $request->password;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);

        $messages = [
            'required' => '*preenchimento obrigatório.',
            'unique' => '*já existe um usuário cadastrado com este email.',
        ];
        $validator = Validator::make($request->all(), [
                    'email' => 'required|unique:users',
                    'password' => 'required:users',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $user->save();
            $user->accounts()->sync($request->accounts);

            return view('users.showUser', [
                'user' => $user,
                'userAuth' => $userAuth,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        $userAuth = Auth::user();

        return view('users.showUser', [
            'user' => $user,
            'userAuth' => $userAuth,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request) {
        $userAuth = Auth::user();

        $accountsChecked = Account::whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->pluck('id')
                ->toArray();

        $accounts = Account::whereHas('users', function ($query) use ($userAuth) {
                    $query->where('users.id', $userAuth->id);
                })
                ->get();

        if ($request['role'] === "superadmin") {
            $accounts = Account::where('id', '>', 0)
                    ->orderBy('NAME', 'asc')
                    ->get();

            return view('users.superadmin_editUser', [
                'user' => $user,
                'userAuth' => $userAuth,
                'accounts' => $accounts,
                'accountsChecked' => $accountsChecked,
            ]);
        } elseif ($request['role'] === "administrator") {

            $accountsID = Account::whereHas('users', function ($query) use ($userAuth) {
                        $query->where('users.id', $userAuth->id);
                    })
                    ->get('id');

            $accounts = Account::whereIn('id', $accountsID)
                    ->orderBy('ID', 'ASC')
                    ->get();

            return view('users.administrator_editUser', [
                'user' => $user,
                'userAuth' => $userAuth,
                'accounts' => $accounts,
                'accountsChecked' => $accountsChecked,
            ]);
        } elseif ($request['role'] === "employee") {

            return view('users.employee_editUser', [
                'user' => $user,
                'userAuth' => $userAuth,
                'accounts' => $accounts,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {

        if (!empty($request->perfil)) {
            $user->perfil = $request->perfil;
        }
        $user->email = $request->email;
        $user->default_password = $request->default_password;
        if (!empty($request->password)) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $path = $request->file('profile_picture')->store('profile_pictures');
        $user->profile_picture = $path;
//        dd($user->profile_picture);
        $user->update();

        if (!empty($request->accounts)) {
            $user->accounts()->sync($request->accounts);
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('user.index');
    }

    public function dashboardUser() {
        $userAuth = Auth::user();
        $today = date('Y-m-d');

        if (Auth::check()) {

            $accountsID = Account::whereHas('users', function ($query) use ($userAuth) {
                        $query->where('users.id', $userAuth->id);
                    })
                    ->pluck('id');

            $tasks = Task::whereIn('account_id', $accountsID)
                    ->get();

            $journeys = Journey::whereIn('account_id', $accountsID)
                    ->get();

            $tasks_now = $tasks
                    ->where('status', 'fazendo agora')
                    ->count();

            $tasks_pending = $tasks
                    ->whereIn('status', ['fazendo agora', 'pendente'])
                    ->count();

            $tasks_my = $tasks
                    ->whereIn('status', ['fazendo agora', 'pendente'])
                    ->where('user_id', $userAuth->id)
                    ->count();

            $hoursTotal = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->sum('duration');

            $hoursToday = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->where('date_conclusion', $today)
                    ->sum('duration');

            $hoursAugust = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-08-01', '2020-08-31'])
                    ->sum('duration');

            $hoursSeptember = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-09-01', '2020-09-30'])
                    ->sum('duration');

            $hoursOctober = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            $hoursNovember = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            $hoursNovember2 = $journeys
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            return view('users/dashboardUser', [
                'userAuth' => $userAuth,
                'today' => $today,
                'tasks_now' => $tasks_now,
                'tasks_pending' => $tasks_pending,
                'tasks_my' => $tasks_my,
                'hoursTotal' => $hoursTotal,
                'hoursToday' => $hoursToday,
                'hoursAugust' => $hoursAugust,
                'hoursSeptember' => $hoursSeptember,
                'hoursOctober' => $hoursOctober,
                'hoursNovember' => $hoursNovember,
                'hoursNovember2' => $hoursNovember2,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function dashboardAdministrator() {
        $userAuth = Auth::user();
        $today = date('Y-m-d');

        if (Auth::check()) {

            $accountsID = Account::whereHas('users', function ($query) use ($userAuth) {
                        $query->where('users.id', $userAuth->id);
                    })
                    ->pluck('id');

            $tasks = Task::whereIn('account_id', $accountsID)
                    ->get();

            $journeys = Journey::whereIn('account_id', $accountsID)
                    ->get();

            $tasks_now = $tasks
                    ->where('status', 'fazendo agora')
                    ->count();

            $tasks_pending = $tasks
                    ->whereIn('status', ['fazendo agora', 'pendente'])
                    ->count();

            $tasks_my = $tasks
                    ->whereIn('status', ['fazendo agora', 'pendente'])
                    ->where('user_id', $userAuth->id)
                    ->count();

            $hoursTotal = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->sum('duration');

            $hoursToday = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->where('date_conclusion', $today)
                    ->sum('duration');

            $hoursAugust = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-08-01', '2020-08-31'])
                    ->sum('duration');

            $hoursSeptember = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-09-01', '2020-09-30'])
                    ->sum('duration');

            $hoursOctober = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            $hoursNovember = $tasks
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date_conclusion', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            $hoursNovember2 = $journeys
                    ->where('status', 'concluida')
                    ->where('user_id', $userAuth->id)
                    ->whereBetween('date', ['2020-10-01', '2020-10-31'])
                    ->sum('duration');

            return view('users/dashboardAdministrator', [
                'userAuth' => $userAuth,
                'today' => $today,
                'tasks_now' => $tasks_now,
                'tasks_pending' => $tasks_pending,
                'tasks_my' => $tasks_my,
                'hoursTotal' => $hoursTotal,
                'hoursToday' => $hoursToday,
                'hoursAugust' => $hoursAugust,
                'hoursSeptember' => $hoursSeptember,
                'hoursOctober' => $hoursOctober,
                'hoursNovember' => $hoursNovember,
                'hoursNovember2' => $hoursNovember2,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function storeProfilePicture(Request $request) {
//            $account_id = $request->acocunt_id;
        $user = User::find(auth::user()->id);
        $path = $request->file('profile_picture')->store('profile_pictures');
        $user->profile_picture = $path;
//            dd($user->image); 
        $user->update();
        echo $path;

        return redirect()->back();
    }

}
