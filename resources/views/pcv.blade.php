@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Determinar vertice inicial (Vertice inicial: {{$verticeInicial }})</div>
                <div class="panel-body text-center">
                    <form method="post" action="{{route('aresta.pcv.vertice')}}">
                        {{ csrf_field() }}
                        <input type="text" class="input-sm" name="verticeInicial"/>
                        <button type="submit" class="btn btn-default">Executar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('aresta.incluir') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Menor caminho</div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if(isset($pcv) && count($pcv) > 0)
                                @foreach($pcv as $aresta)
                                    <a class="list-group-item list-group-item-action">
                                        {{$aresta['i']}} => {{$aresta['j']}} (Peso: {{$aresta['p']}})
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('aresta.incluir') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Grafo</div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if(isset($data) && count($data) > 0)
                                @foreach($data as $aresta)
                                    <a class="list-group-item list-group-item-action">
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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Representação (para dar zoom use o scrool do mouse)</div>
                <div class="panel-body">
                    <div id="graphDiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
