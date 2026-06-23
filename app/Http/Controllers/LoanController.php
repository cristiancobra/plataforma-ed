<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Collection;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use Illuminate\Support\Facades\DB;
use PDF;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Detecta se há filtros ativos
        $filtersActive = collect($request->except(['page', 'trash', 'role']))
            ->filter(function ($v) {
                return !is_null($v) && trim($v) !== '';
            })
            ->count() > 0;

        $query = Loan::query()
            ->where('account_id', auth()->user()->account_id)
            ->with(['lender.contact', 'borrowerUser.contact', 'borrowerContact', 'collections']);

        // Total geral SEM filtro
        $totalTotal = Loan::where('account_id', auth()->user()->account_id)
            ->where('trash', $request->has('trash') && $request->trash == 1 ? 1 : 0)
            ->count();

        // Filtros opcionais
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lender_id')) {
            $query->where('lender_user_id', $request->lender_id);
        }

        if ($request->filled('borrower_name')) {
            $borrowerName = $request->borrower_name;
            $query->where(function ($q) use ($borrowerName) {
                $q->whereHas('borrowerUser.contact', function ($qu) use ($borrowerName) {
                    $qu->where('name', 'like', '%' . $borrowerName . '%');
                })
                ->orWhereHas('borrowerContact', function ($qc) use ($borrowerName) {
                    $qc->where('name', 'like', '%' . $borrowerName . '%');
                });
            });
        }

        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }

        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        if ($request->has('overdue') && $request->overdue == 1) {
            $query->overdue();
        }

        // Trash
        if ($request->has('trash') && $request->trash == 1) {
            $query->where('trash', 1);
        } else {
            $query->where('trash', 0);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(20);
        $totalFiltered = $loans->total();

        // Select options para filtros
        $statusSelectOptions = Loan::returnStatus();
        $lenderSelectOptions = User::where('account_id', auth()->user()->account_id)
            ->with('contact')
            ->get()
            ->pluck('contact.name', 'id')
            ->toArray();
        $trashStatus = $request->trash;

        return view('loans.indexLoans', compact(
            'loans',
            'statusSelectOptions',
            'lenderSelectOptions',
            'trashStatus',
            'totalTotal',
            'totalFiltered',
            'filtersActive'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lenderSelectOptions = User::where('account_id', auth()->user()->account_id)
            ->with('contact')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->contact->name ?? $user->name];
            })
            ->toArray();

        $borrowerUserSelectOptions = User::where('account_id', auth()->user()->account_id)
            ->with('contact')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->contact->name ?? $user->name];
            })
            ->toArray();

        $borrowerContactSelectOptions = Contact::where('account_id', auth()->user()->account_id)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        $availableCollections = Collection::where('account_id', auth()->user()->account_id)
            ->whereHas('collectionType', function ($q) {
                $q->where('category', 'físico');
            })
            ->where('status', 'available')
            ->where('trash', 0)
            ->with('collectionType')
            ->orderBy('name')
            ->get();

        return view('loans.createLoan', compact(
            'lenderSelectOptions',
            'borrowerUserSelectOptions',
            'borrowerContactSelectOptions',
            'availableCollections'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {
        try {
            DB::beginTransaction();

            // Criar o empréstimo
            $loan = new Loan();
            $loan->account_id = auth()->user()->account_id;
            $loan->lender_user_id = $request->lender_user_id;
            
            if ($request->borrower_type === 'user') {
                $loan->borrower_user_id = $request->borrower_user_id;
            } else {
                $loan->borrower_contact_id = $request->borrower_contact_id;
            }
            
            $loan->start_date = $request->start_date;
            $loan->due_date = $request->due_date;
            $loan->notes = $request->notes;
            $loan->status = 'active';
            $loan->save();

            // Adicionar os itens ao empréstimo
            foreach ($request->collection_ids as $index => $collectionId) {
                $condition = $request->conditions[$collectionId] ?? null;
                
                LoanItem::create([
                    'loan_id' => $loan->id,
                    'collection_id' => $collectionId,
                    'condition_on_loan' => $condition,
                ]);

                // Atualizar status da Collection para 'in use'
                Collection::where('id', $collectionId)
                    ->update(['status' => 'in use']);
            }

            DB::commit();

            return redirect()->route('loan.show', [$loan])
                ->with('success', 'Empréstimo criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar empréstimo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        $loan->load([
            'lender.contact',
            'borrowerUser.contact',
            'borrowerContact',
            'loanItems.collection.collectionType',
        ]);

        $statusOptions = Loan::returnStatus();

        return view('loans.showLoan', compact('loan', 'statusOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $loan->load(['loanItems.collection']);

        return view('loans.editLoan', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanRequest  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        try {
            DB::beginTransaction();

            $loan->due_date = $request->due_date;
            $loan->notes = $request->notes;

            // Se data de devolução foi informada, atualizar status e restaurar collections
            if ($request->filled('returned_date')) {
                $loan->returned_date = $request->returned_date;
                $loan->status = 'returned';

                // Atualizar condições de devolução dos itens
                if ($request->has('conditions_on_return')) {
                    foreach ($request->conditions_on_return as $loanItemId => $condition) {
                        LoanItem::where('id', $loanItemId)
                            ->update(['condition_on_return' => $condition]);
                    }
                }

                // Restaurar status das Collections para 'available'
                foreach ($loan->loanItems as $loanItem) {
                    Collection::where('id', $loanItem->collection_id)
                        ->update(['status' => 'available']);
                }
            }

            $loan->save();

            DB::commit();

            return redirect()->route('loan.show', [$loan])
                ->with('success', 'Empréstimo atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar empréstimo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        // Restaurar status das collections antes de deletar
        foreach ($loan->loanItems as $loanItem) {
            if ($loan->status !== 'returned') {
                Collection::where('id', $loanItem->collection_id)
                    ->update(['status' => 'available']);
            }
        }

        $loan->delete();

        return redirect()->route('loan.index')
            ->with('success', 'Empréstimo removido com sucesso!');
    }

    /**
     * Move the specified resource to trash.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function trash(Loan $loan)
    {
        $loan->trash = 1;
        $loan->save();

        return redirect()->route('loan.index')
            ->with('success', 'Empréstimo movido para lixeira!');
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $loan = Loan::find($id);
        $loan->trash = 0;
        $loan->save();

        return redirect()->route('loan.show', [$loan])
            ->with('success', 'Empréstimo restaurado da lixeira!');
    }

    /**
     * Mark the loan as returned.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function return(Request $request, Loan $loan)
    {
        $request->validate([
            'returned_date' => 'nullable|date',
            'conditions_on_return' => 'nullable|array',
            'conditions_on_return.*' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $loan->returned_date = $request->returned_date ?? now();
            $loan->status = 'returned';
            $loan->save();

            // Atualizar condições de devolução dos itens
            if ($request->has('conditions_on_return')) {
                foreach ($request->conditions_on_return as $loanItemId => $condition) {
                    LoanItem::where('id', $loanItemId)
                        ->update(['condition_on_return' => $condition]);
                }
            }

            // Restaurar status das Collections para 'available'
            foreach ($loan->loanItems as $loanItem) {
                Collection::where('id', $loanItem->collection_id)
                    ->update(['status' => 'available']);
            }

            DB::commit();

            return redirect()->route('loan.show', [$loan])
                ->with('success', 'Devolução registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao registrar devolução: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for loan.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function createPDF(Loan $loan)
    {
        $loan->load([
            'lender.contact',
            'borrowerUser.contact',
            'borrowerContact',
            'loanItems.collection.collectionType',
        ]);

        // Definir o nome do devedor
        if ($loan->borrower_user_id && $loan->borrowerUser) {
            $borrowerName = $loan->borrowerUser->contact->name ?? $loan->borrowerUser->name;
            $borrowerType = 'Usuário Interno';
        } elseif ($loan->borrower_contact_id && $loan->borrowerContact) {
            $borrowerName = $loan->borrowerContact->name;
            $borrowerType = 'Contato Externo';
        } else {
            $borrowerName = 'Não especificado';
            $borrowerType = '-';
        }

        // Definir o nome do emprestador
        if ($loan->lender && $loan->lender->contact) {
            $lenderName = $loan->lender->contact->name;
        } else {
            $lenderName = $loan->lender->name ?? 'Não especificado';
        }

        // Definir status
        $statusText = '';
        if ($loan->isOverdue()) {
            $statusText = 'ATRASADO';
        } else {
            switch ($loan->status) {
                case 'pending':
                    $statusText = 'PENDENTE';
                    break;
                case 'active':
                    $statusText = 'ATIVO';
                    break;
                case 'returned':
                    $statusText = 'DEVOLVIDO';
                    break;
                case 'cancelled':
                    $statusText = 'CANCELADO';
                    break;
            }
        }

        $data = [
            'pdfTitle' => 'EMPRÉSTIMO',
            'accountLogo' => $loan->account?->image?->path ?? 'images/logo-default.png',
            'accountPrincipalColor' => $loan->account?->principal_color ?? '#000000',
            'accountComplementaryColor' => $loan->account?->complementary_color ?? '#ffffff',
            'accountName' => $loan->account?->name ?? '',
            'accountEmail' => $loan->account?->email ?? '',
            'accountPhone' => $loan->account?->phone ?? '',
            'accountAddress' => $loan->account?->address ?? '',
            'accountCity' => $loan->account?->city ?? '',
            'accountState' => $loan->account?->state ?? '',
            'accountCnpj' => $loan->account?->cnpj ?? '',
            'loanId' => $loan->id,
            'lenderName' => $lenderName,
            'borrowerName' => $borrowerName,
            'borrowerType' => $borrowerType,
            'startDate' => $loan->start_date,
            'dueDate' => $loan->due_date,
            'returnedDate' => $loan->returned_date,
            'status' => $statusText,
            'notes' => $loan->notes,
            'loanItems' => $loan->loanItems,
            'totalItems' => $loan->loanItems->count(),
        ];

        // Limpa qualquer output que possa corromper o PDF
        if (ob_get_length()) {
            ob_clean();
        }

        $pdf = PDF::loadView('loans.pdf', compact('data'))
            ->setOptions([
                'page-size' => 'A4',
            ]);

        // Stream PDF
        $accountName = $loan->account?->name ?? 'Emprestimo';
        return $pdf->stream("Emprestimo_" . $loan->id . "_" . $accountName . ".pdf");
    }
}
