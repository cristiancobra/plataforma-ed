<?php

namespace app\Http\Traits;
use Illuminate\Http\Request;
use App\Models\Contact;

trait FilterModelTrait {
    
    public function filterModel(Request $request) {
        $items = Contact::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->priority) {
                        $query->where('priority', $request->priority);
                    }
                    if ($request->status == '') {
                        // busca todos
                    } elseif ($request->status == 'fazendo') {
                        $query->where('status', 'fazer');
                        $query->whereHas('journeys');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
                    }
                })
                ->with(
                        'opportunity',
                        'journeys',
                        'user.contact',
                        'user.image',
                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
//                ->orderBy('date_due', 'DESC')
                ->paginate(20);

        $items->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        return $items;
    }
    }