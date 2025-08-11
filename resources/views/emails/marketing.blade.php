@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
	<img src= '{{$account->logo}}' width='150px' height='50px'>
	<br>
	{{$account->name}}
        @endcomponent
    @endslot

    {{-- Body --}}
{!!html_entity_decode($email->message)!!} 

  {{-- Subcopy --}}
    @slot('subcopy')
        @component('mail::subcopy')
            <!-- subcopy here -->
        @endcomponent
    @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Se você não deseja mais receber esses emails descadastre-se aqui.
        @endcomponent
    @endslot
@endcomponent

