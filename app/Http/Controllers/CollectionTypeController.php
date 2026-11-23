<?php

namespace App\Http\Controllers;

use App\Models\CollectionField;
use App\Models\CollectionType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCollectionTypeRequest;
use App\Http\Requests\UpdateCollectionTypeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollectionTypeController extends Controller
{
    public function index()
    {
        $accountId = Auth::user()->account_id;
        $types = CollectionType::where('account_id', $accountId)->with('fields')->orderBy('name')->get();
        return view('collection_types.indexCollectionTypes', compact('types'));
    }

    public function create()
    {
        $availableFields = $this->availableFields();
        $globalFields = $this->globalFields();

        return view('collection_types.createCollectionTypes', compact('availableFields', 'globalFields'));
    }

    public function store(StoreCollectionTypeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->typeData();
            $data['account_id'] = Auth::user()->account_id;
            $collectionType = CollectionType::create($data);
            $this->syncFields($collectionType, $request);
        });

        return redirect()->route('collection-types.index')->with('success', 'Tipo criado com sucesso!');
    }

    public function show(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        $collectionType->load('fields');
        $globalFields = $this->globalFields();
        return view('collection_types.showCollectionTypes', compact('collectionType', 'globalFields'));
    }

    public function edit(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        $availableFields = $this->availableFields();
        $globalFields = $this->globalFields();
        return view('collection_types.editCollectionTypes', compact('collectionType', 'availableFields', 'globalFields'));
    }

    public function update(UpdateCollectionTypeRequest $request, CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        DB::transaction(function () use ($request, $collectionType) {
            $collectionType->update($request->typeData());
            $this->syncFields($collectionType, $request);
        });
        return redirect()->route('collection-types.index')->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy(CollectionType $collectionType)
    {
        $this->authorizeType($collectionType);
        $collectionType->delete();
        return redirect()->route('collection-types.index')->with('success', 'Tipo removido com sucesso!');
    }

    /**
     * Associa ao tipo os campos marcados e cria os campos novos informados no próprio formulário.
     */
    private function syncFields(CollectionType $collectionType, $request): void
    {
        // campos gerais valem para todos os tipos: nunca são vinculados pelo tipo
        $fieldIds = CollectionField::ofCurrentAccount()
            ->where('is_global', false)
            ->whereIn('id', $request->fieldIds())
            ->pluck('id')
            ->all();
        foreach ($request->newFields() as $data) {
            $fieldIds[] = CollectionField::createForCurrentAccount([
                'label' => $data['label'],
                'type' => $data['type'],
                'options' => $data['options'],
                'required' => $data['required'],
            ])->id;
        }
        $collectionType->fields()->sync($fieldIds);
    }

    /**
     * Campos da conta que podem ser escolhidos para um tipo (os desativados aparecem marcados como tal).
     */
    private function availableFields()
    {
        return CollectionField::ofCurrentAccount()->where('is_global', false)->orderByDesc('active')->ordered()->get();
    }

    /**
     * Campos gerais ativos da conta, herdados por todos os tipos.
     */
    private function globalFields()
    {
        return CollectionField::ofCurrentAccount()->active()->where('is_global', true)->ordered()->get();
    }

    private function authorizeType(CollectionType $type)
    {
        if ($type->account_id !== Auth::user()->account_id) {
            abort(403);
        }
    }
}
