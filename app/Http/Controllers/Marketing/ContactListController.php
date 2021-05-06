<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Http\Request;

class ContactListController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $contactLists = ContactList::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->whereHas('account', function ($query) use ($request) {
                    if (isset($request->account_id)) {
                        $query->where('account_id', '=', $request->account_id);
                    } else {
                        $query->where('accounts.id', '>', 0);
                    }
                })
                ->where(function ($query) use ($request) {
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                })
//                ->with('contacts')
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $total = $contactLists->total();

        return view('marketing.contactList.index', compact(
                        'contactLists',
                        'accounts',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $contacts = Contact::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->paginate(20);

        return view('marketing.contactList.create', compact(
                        'accounts',
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
        $contactList = new ContactList();
        $contactList->fill($request->all());

        $messages = [
            'unique' => 'Já existe um contato com este :attribute.',
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:contact_list',
//					'last_name' => 'required:tasks',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $contactList->save();

            $contacts = Contact::where(function ($query) use ($request) {
                        $query->whereIn('account_id', userAccounts());
                                if($request->type) {
                                    $query->where('type', $request->type);
                                }
//                        if ($request->name) {
//                            $query->where('name', 'like', "%$request->name%");
//                        }
//                        if ($request->user_id == 'all') {
////						echo 'todos';
//                            $query->where('user_id', '>', 0);
//                        } elseif ($request->user_id) {
//                            $query->where('user_id', $request->user_id);
//                        } else {
//                            $query->where('user_id', auth()->user()->id);
//                        }
//                        if ($request->contact_id) {
//                            $query->where('contact_id', $request->contact_id);
//                        }
//                        if ($request->status) {
//                            $query->where('status', $request->status);
//                        } else {
//                            $query->where('status', 'fazer');
//                        }
                    })
                    ->get();

            $contactList->contacts()->saveMany($contacts);
        }

        return view('marketing.contactList.show', compact(
                        'contactList',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactList  $contactList
     * @return \Illuminate\Http\Response
     */
    public function show(ContactList $contactList) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactList  $contactList
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactList $contactList) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactList  $contactList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactList $contactList) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactList  $contactList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactList $contactList) {
        //
    }

}
