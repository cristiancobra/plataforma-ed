<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attachment;
use App\Models\Image;
use App\Models\Page;
use App\Models\Text;
use App\Models\User;
use App\Http\Requests\StoreTextRequest;

class TextController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texts = $this->filterTexts($request);

        $valueOffer = Text::myValueOffer();
        $about = Text::myAbout();
        $strengths = Text::myStrengths();
        //dd($strengths);
        $users = User::myUsers();
        $status = Text::returnStatus();
        $departments = Text::returnDepartments();
        $trashStatus = request()->trash;

        return view('libraries/texts/index', compact(
            'texts',
            'users',
            'status',
            'departments',
            'trashStatus',
            'valueOffer',
            'about',
            'strengths',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Text::returnDepartments();
        $status = Text::returnStatus();
        $types = Text::returnTypes();

        // campos enviados por request
        //        $taskName = $request->task_name;
        //        $opportunityId = $request->opportunity_id;
        //        $opportunityName = $request->opportunity_name;
        //        $opportunityContactName = $request->contact_name;
        //        $opportunityContactId = $request->contact_id;
        //        $taskAccountName = $request->account_name;
        //        $taskAccountId = $request->account_id;
        //        $department = 'vendas';

        return view('libraries/texts/create', compact(
            'departments',
            'status',
            'types',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTextRequest $request)
    {
        $text = new Text();
        $text->fill($request->all());
        $text->account_id = auth()->user()->account_id;
        $text->user_id = auth()->user()->id;
        $text->save();

        $this->handleImageUpload($request, $text);
        $this->handleAttachmentUpload($request, $text);

        return redirect()->route('text.show', [$text]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\texts  $text
     * @return \Illuminate\Http\Response
     */
    public function show(text $text)
    {

        switch ($text->type) {
            case 'apresentação da empresa':
                $pages = Page::where('account_id', auth()->user()->account_id)
                    ->where('company_about', 1)
                    ->get();
                break;
            case 'proposta de valor':
                $pages = Page::where('account_id', auth()->user()->account_id)
                    ->where('text_value_offer', 1)
                    ->get();
                break;
            case 'força':
                $pages = Page::where('account_id', auth()->user()->account_id)
                    ->where('company_strengths', 1)
                    ->get();
                break;
            default:
                $pages = null;
        }

        $status = $text->status;
        $priority = $text->priority;
        
        $text->load(['images', 'attachments']);

        return view('libraries/texts/show', compact(
            'text',
            'pages',
            'status',
            'priority',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\texts  $text
     * @return \Illuminate\Http\Response
     */
    public function edit(text $text)
    {
        $users = User::myUsers();
        $departments = Text::returnDepartments();
        $status = Text::returnStatus();
        $types = Text::returnTypes();

        return view('libraries/texts/edit', compact(
            'users',
            'text',
            'departments',
            'status',
            'types',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTextRequest $request, text $text)
    {
        $text->fill($request->all());
        $text->save();

        $this->handleImageUpload($request, $text);
        $this->handleAttachmentUpload($request, $text);


        return redirect()->route('text.show', [$text])
            ->with('success', 'Texto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $text = Text::find($id);
        $text->delete();

        return redirect()->route('text.index')
            ->with('success', 'Texto apagado com sucesso!');
    }

    /**
     * Move the specified resource to trash.
     *
     * @param  \App\Models\Text  $text
     * @return \Illuminate\Http\Response
     */
    public function sendToTrash(Text $text)
    {
        $text->trash = 1;
        $text->save();

        return redirect()->route('text.index')->with('success', 'Texto movido para a lixeira com sucesso!');
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  \App\Models\Text  $text
     * @return \Illuminate\Http\Response
     */
    public function restoreFromTrash(Text $text)
    {
        $text->trash = 0;
        $text->save();

        return redirect()->back()->with('success', 'Texto restaurado com sucesso!');
    }


    public static function filterTexts(Request $request)
    {
        $texts = Text::where(function ($query) use ($request) {
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
            if ($request->type) {
                $query->where('type', $request->type);
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            if ($request->trash == 1) {
                $query->where('trash', 1);
            } else {
                $query->where('trash', '!=', 1);
            }
        })
            ->with(
                'user.contact',
                'user.image',
                //                        'images',
            )
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        $texts->appends([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'department' => $request->department,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return $texts;
    }


    /**
     * Handle image upload for text
     */
    private function handleImageUpload(Request $request, Text $text)
    {
        if ($request->file('image')) {
            $image = new Image();
            $image->account_id = auth()->user()->account_id;
            $image->task_id = $text->task_id;
            $image->text_id = $text->id;
            $image->type = 'imagem de texto';
            $image->name = 'Imagem do texto ' . $text->name;
            $image->status = 'disponível';
            $path = $request->file('image')->store('customers_images', 'public');
            $image->path = $path;
            $image->save();
        }
    }

    /**
     * Handle PDF/attachment upload for text
     */
    private function handleAttachmentUpload(Request $request, Text $text)
    {
        if ($request->file('attachment')) {
            $attachment = new Attachment();
            $attachment->account_id = auth()->user()->account_id;
            $attachment->text_id = $text->id;
            $attachment->type = 'pdf';
            $attachment->name = $request->file('attachment')->getClientOriginalName();
            $attachment->status = 'disponível';
            $path = $request->file('attachment')->store('customers_attachments', 'public');
            $attachment->path = $path;
            $attachment->save();
        }
    }
}
