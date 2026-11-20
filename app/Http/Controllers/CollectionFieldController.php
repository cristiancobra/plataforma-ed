<?php

namespace App\Http\Controllers;

use App\Enums\CustomFieldType;
use App\Http\Requests\CollectionFieldRequest;
use App\Models\CollectionField;
use App\Models\CollectionType;

/**
 * Campos personalizados dos itens de acervo, gerenciados pelo próprio cliente.
 * Restrito a dono/administrador, já que mudam o formulário de todos os usuários da conta.
 */
class CollectionFieldController extends Controller
{
    private const MANAGER_PROFILES = ['super administrador', 'dono', 'administrador'];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->perfil, self::MANAGER_PROFILES, true)) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function index()
    {
        $fields = CollectionField::ofCurrentAccount()
            ->with('collectionType')
            ->orderByDesc('active')
            ->ordered()
            ->get();

        return view('collection_fields.indexCollectionFields', compact('fields'));
    }

    public function create()
    {
        $field = new CollectionField(['type' => CustomFieldType::Text, 'active' => true]);

        return view('collection_fields.createCollectionField', $this->formData($field));
    }

    public function store(CollectionFieldRequest $request)
    {
        $field = new CollectionField($request->validatedData());
        $field->account_id = auth()->user()->account_id;
        $field->key = CollectionField::generateKey($field->label, $field->account_id);
        $field->save();

        return redirect()->route('collection-field.index')
            ->with('success', 'Campo "' . $field->label . '" criado com sucesso!');
    }

    public function edit(CollectionField $collectionField)
    {
        return view('collection_fields.editCollectionField', $this->formData($collectionField));
    }

    public function update(CollectionFieldRequest $request, CollectionField $collectionField)
    {
        // a key nunca muda: é ela que liga o campo aos valores já gravados nos itens
        $collectionField->update($request->validatedData());

        return redirect()->route('collection-field.index')
            ->with('success', 'Campo "' . $collectionField->label . '" atualizado com sucesso!');
    }

    /**
     * "Excluir" apenas desativa: o campo some dos formulários, mas os valores continuam gravados
     * nos itens e voltam a aparecer se o campo for reativado.
     */
    public function destroy(CollectionField $collectionField)
    {
        $collectionField->update(['active' => false]);

        return redirect()->route('collection-field.index')
            ->with('success', 'Campo "' . $collectionField->label . '" desativado. Os valores já preenchidos foram mantidos.');
    }

    public function activate(CollectionField $collectionField)
    {
        $collectionField->update(['active' => true]);

        return redirect()->route('collection-field.index')
            ->with('success', 'Campo "' . $collectionField->label . '" reativado.');
    }

    private function formData(CollectionField $field): array
    {
        $typeOptions = CustomFieldType::selectOptions();
        // tipos para os quais o campo pode mudar sem invalidar valores já gravados
        $lockedTypes = [];
        if ($field->exists && $field->hasValues()) {
            foreach (CustomFieldType::cases() as $case) {
                if (!$field->type->canChangeTo($case)) {
                    $lockedTypes[] = $case->value;
                }
            }
        }

        return [
            'field' => $field,
            'typeOptions' => $typeOptions,
            'lockedTypes' => $lockedTypes,
            'collectionTypeOptions' => CollectionType::collectionTypeSelectOptions(),
        ];
    }
}
