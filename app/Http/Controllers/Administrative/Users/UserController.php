<?php

namespace App\Http\Controllers\Administrative\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Journey;
use App\Models\Task;
use App\Models\User;
use DB;

class UserController extends Controller {

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $users = User::where('account_id', auth()->user()->account_id)
                ->with([
                    'contact',
                    'image',
                ])
                ->orderBy('ID', 'ASC')
                ->paginate(20);

        $users->appends([
            'name' => $request->name,
            'account_id' => $request->account_id,
        ]);

        $total = $users->total();

        return view('administrative.users.index', compact(
                        'users',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'funcionário')
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('administrative.users.create', compact(
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
        $user = new User();
        $user->account_id = auth()->user()->account_id;
        $user->fill($request->all());
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

            return view('administrative.users.show', compact(
                            'user',
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {

        $userTasks = Task::where('user_id', $user->id)
                ->where('trash', '!=', 1)
                ->orderBy('date_due', 'DESC')
                                ->paginate(15);

        foreach ($userTasks as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
        }


        return view('administrative.users.show', compact(
                        'user',
                        'userTasks',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $images = Image::where('account_id', auth()->user()->account_id)
                ->get();

        return view('administrative.users.edit', compact(
                        'user',
                        'contacts',
                        'images',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        $user->fill($request->all());

        if ($request->file) {
            $path = $request->file('image_id')->store('users_images');
            $user->profile_picture = $path;
        }
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

            $tasks = Task::where('account_id', auth()->user()->account_id)
                    ->get();

            $journeys = Journey::where('account_id', auth()->user()->account_id)
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

            $tasks = Task::where('account_id', auth()->user()->account_id)
                    ->get();

            $journeys = Journey::where('account_id', auth()->user()->account_id)
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

    public function report() {
        $users = User::where('users.id', '>', 0)
                ->with(
                        'account',
                        'contact',
                )
                ->orderBy('users.created_at', 'DESC')
                ->paginate(50);

        $total = $users->total();

        return view('administrative.users.report', compact(
                        'users',
                        'total',
        ));
    }

}
