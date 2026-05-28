<?php

namespace App\Http\Controllers;

use App\Models\CollectionsGroup;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCollectionsGroupRequest;
use App\Http\Requests\UpdateCollectionsGroupRequest;
use Illuminate\Support\Facades\Auth;

class CollectionsGroupController extends Controller
{
    public function index()
    {
        $accountId = Auth::user()->account_id;
        $groups = CollectionsGroup::where('account_id', $accountId)->orderBy('name')->get();
        return view('collections_group.indexCollectionsGroups', compact('groups'));
    }

    public function create()
    {
        return view('collections_group.createCollectionsGroup');
    }

    public function store(StoreCollectionsGroupRequest $request)
    {
        $data = $request->validated();
        $data['account_id'] = Auth::user()->account_id;
        CollectionsGroup::create($data);
        return redirect()->route('collections-group.index')->with('success', 'Acervo criado com sucesso!');
    }

    public function show(CollectionsGroup $collections_group)
    {
        $this->authorizeGroup($collections_group);
        return view('collections_group.showCollectionsGroup', compact('collections_group'));
    }

    public function edit(CollectionsGroup $collections_group)
    {
        $this->authorizeGroup($collections_group);
        return view('collections_group.editCollectionsGroup', compact('collections_group'));
    }

    public function update(UpdateCollectionsGroupRequest $request, CollectionsGroup $collections_group)
    {
        $this->authorizeGroup($collections_group);
        $collections_group->update($request->validated());
        return redirect()->route('collections-group.index')->with('success', 'Acervo atualizado com sucesso!');
    }

    public function destroy(CollectionsGroup $collections_group)
    {
        $this->authorizeGroup($collections_group);
        $collections_group->delete();
        return redirect()->route('collections-group.index')->with('success', 'Acervo removido com sucesso!');
    }

    private function authorizeGroup(CollectionsGroup $group)
    {
        if ($group->account_id !== Auth::user()->account_id) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
