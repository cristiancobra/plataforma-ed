<?php

namespace App\Http\Controllers;

use App\Models\CollectionType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCollectionTypeRequest;
use App\Http\Requests\UpdateCollectionTypeRequest;
use Illuminate\Support\Facades\Auth;

class CollectionTypeController extends Controller
{
    public function index()
    {
        $accountId = Auth::user()->account_id;
        $types = CollectionType::where('account_id', $accountId)->orderBy('name')->get();
        return view('collection_types.indexCollectionTypes', compact('types'));
    }

    public function create()
    {
        return view('collection_types.createCollectionTypes');
    }

    public function store(StoreCollectionTypeRequest $request)
    {
        $data = $request->validated();
        $data['account_id'] = Auth::user()->account_id;
        CollectionType::create($data);
        return redirect()->route('collection-types.index')->with('success', 'Tipo criado com sucesso!');
    }

    public function show(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        return view('collection_types.showCollectionTypes', compact('collectionType'));
    }

    public function edit(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        return view('collection_types.editCollectionTypes', compact('collectionType'));
    }

    public function update(UpdateCollectionTypeRequest $request, CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        $collectionType->update($request->validated());
        return redirect()->route('collection-types.index')->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        $collectionType->delete();
        return redirect()->route('collection-types.index')->with('success', 'Tipo removido com sucesso!');
    }

    private function authorizeType(CollectionType $type)
    {
        if ($type->account_id !== Auth::user()->account_id) {
            abort(403);
        }
    }
}
