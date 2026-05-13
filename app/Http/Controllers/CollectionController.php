<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CollectionLocation;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Collection::query()
            ->where('account_id', auth()->user()->account_id)
            ->with(['currentLocation', 'user.contact', 'contact']);


        // Filtros opcionais
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('patrimony_number')) {
            $query->where('patrimony_number', 'like', '%' . $request->patrimony_number . '%');
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('location')) {
            $query->whereHas('currentLocation', function ($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('trash') && $request->trash == 1) {
            $query->where('trash', 1);
        } else {
            $query->where('trash', 0);
        }

        $collections = $query->orderBy('created_at', 'desc')->paginate(20);

        $categories = Collection::returnCategories();
        $types = Collection::returnTypes();
        $status = Collection::returnStatus();
        $users = User::myUsers();
        $trashStatus = $request->trash;

        return view('libraries/collections/index', compact(
            'collections',
            'categories',
            'types',
            'status',
            'users',
            'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Collection::returnCategories();
        $types = Collection::returnTypes();
        $status = Collection::returnStatus();
        $contacts = Contact::where('account_id', auth()->user()->account_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('libraries/collections/create', compact(
            'categories',
            'types',
            'status',
            'contacts',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionRequest $request)
    {
        $collection = new Collection();
        $collection->fill($request->all());
        $collection->account_id = auth()->user()->account_id;
        $collection->user_id = auth()->user()->id;
        $collection->save();

        // Criar localização inicial se fornecida
        if ($request->has('initial_location')) {
            CollectionLocation::create([
                'collection_id' => $collection->id,
                'user_id' => auth()->user()->id,
                'location' => $request->initial_location,
                'notes' => $request->location_notes,
                'moved_at' => now(),
                'is_current' => true,
            ]);
        }

        return redirect()->route('collection.show', [$collection])
            ->with('success', 'Item do acervo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $collection->load(['user.contact', 'currentLocation.user.contact', 'locations.user.contact']);

        return view('libraries/collections/show', compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        $categories = Collection::returnCategories();
        $types = Collection::returnTypes();
        $status = Collection::returnStatus();
        $users = User::myUsers();
        $contacts = Contact::where('account_id', auth()->user()->account_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('libraries/collections/edit', compact(
            'collection',
            'categories',
            'types',
            'status',
            'users',
            'contacts',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCollectionRequest  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        $collection->fill($request->all());
        $collection->save();

        return redirect()->route('collection.show', [$collection])
            ->with('success', 'Item do acervo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()->route('collection.index')
            ->with('success', 'Item do acervo removido com sucesso!');
    }

    /**
     * Move the specified resource to trash.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function trash(Collection $collection)
    {
        $collection->trash = 1;
        $collection->save();

        return redirect()->route('collection.index')
            ->with('success', 'Item movido para lixeira!');
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $collection = Collection::find($id);
        $collection->trash = 0;
        $collection->save();

        return redirect()->route('collection.show', [$collection])
            ->with('success', 'Item restaurado da lixeira!');
    }

    /**
     * Add a new location to the collection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function addLocation(Request $request, Collection $collection)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'moved_at' => 'nullable|date',
        ]);

        // Marcar todas as localizações anteriores como não atuais
        CollectionLocation::where('collection_id', $collection->id)
            ->update(['is_current' => false]);

        // Criar nova localização
        CollectionLocation::create([
            'collection_id' => $collection->id,
            'user_id' => auth()->user()->id,
            'location' => $request->location,
            'notes' => $request->notes,
            'moved_at' => $request->moved_at ?? now(),
            'is_current' => true,
        ]);

        return redirect()->route('collection.show', [$collection])
            ->with('success', 'Localização atualizada com sucesso!');
    }
}
