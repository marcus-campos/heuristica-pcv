@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('aresta.incluir') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Incluir arestas</div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if (isset($result) and $result === true)
                                <div class="alert alert-success">
                                    Aresta removida com sucesso! <a href="{{ route('aresta.remover.index') }}"> Voltar</a>
                                </div>
                            @endif
                            @if(isset($data) && count($data) > 0)
                                @foreach($data as $aresta)
                                    <a href="{{ route('aresta.remover', ['i' => $aresta['i'], 'j' => $aresta['j']]) }}" class="list-group-item list-group-item-action">
                                        I: {{$aresta['i']}}<br>J: {{$aresta['j']}}<br>Peso: {{$aresta['p']}}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
