@extends('layouts.app')

@section('content')
    <div class="content-edit">
        <div class = "card-edit">
            <p class = "title"> Editar </p>
            <a class = "btn-back" href = "{{ route('tenant.library.client') }}"> &larr; Voltar</a> 
                                
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="msn-erro">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class = "card-content-edit">
                <form action="{{ route('tenant.library.client.edit',$client->id) }}" method="post">
                    @csrf
                    @method('put')
                    <input class = "input-w80" type = "text" name = "name" value ="{{ $client->name }}" placeholder="Nome do cliente" />
                    <input class = "input-w80" type = "text" name = "cpf"  value ="{{ $client->cpf }}" 
                            placeholder="Cpf. Exemplo (999.999.999-99)" />
                    <input class = "input-w80" type = "text" name = "telephone" value ="{{ $client->telephone }}" 
                            placeholder="Telefone. Exemplo ( (64)9999-9999)" />
                    <input class = "input-w80" type = "hidden" name = "cpfCurrent"  value ="{{ $client->cpf }}" />
                    <input class = "input-w80" type = "hidden" name = "nameCurrent"  value ="{{ $client->name }}" />
                    <input name = "company_id" type = "hidden" value="{{ session('tenant') }}" />
                    <input class = "input-w80 btn-input" type = "submit" />
                </form >  
            </div><!--\ card-content !-->

        </div><!--\ card-edit !-->
    </div><!--\ content-edit !-->
@endsection