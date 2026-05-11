<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttachmentRequest;
use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttachmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachmentRequest $request)
    {
        $attachment = new Attachment();
        $attachment->account_id = auth()->user()->account_id;
        $attachment->task_id = $request->task_id;
        $attachment->text_id = $request->text_id;
        $attachment->proposal_id = $request->proposal_id;
        $attachment->type = $request->type ?? 'pdf';
        $attachment->name = $request->file('attachment')->getClientOriginalName();
        $attachment->status = 'disponível';
        
        $path = $request->file('attachment')->store('customers_attachments', 'public');
        $attachment->path = $path;
        $attachment->save();

        return redirect()->back()->with('attachment_success', 'Anexo adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        // Verificar se o usuário tem permissão
        if ($attachment->account_id !== auth()->user()->account_id) {
            return redirect()->back()->with('failed', 'Você não tem permissão para editar este anexo.');
        }

        // Validar dados
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'created_at' => 'nullable|date'
        ]);

        // Atualizar dados
        $attachment->type = $request->type;
        $attachment->name = $request->name;
        
        if ($request->created_at) {
            $attachment->created_at = $request->created_at;
        }
        
        $attachment->save();

        return redirect()->back()->with('attachment_success', 'Anexo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        // Verificar se o usuário tem permissão
        if ($attachment->account_id !== auth()->user()->account_id) {
            return redirect()->back()->with('failed', 'Você não tem permissão para excluir este anexo.');
        }

        // Deletar arquivo do storage
        \Storage::disk('public')->delete($attachment->path);
        
        // Deletar registro do banco
        $attachment->delete();

        return redirect()->back()->with('attachment_success', 'Anexo excluído com sucesso!');
    }
}
