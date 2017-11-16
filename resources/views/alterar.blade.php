@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('aresta.alterar') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Arestas</div>
                    <div class="panel-body">
                        @if (isset($result) and $result === true)
                            <div class="alert alert-success">
                                Aresta alterada com sucesso! <a href="{{ route('aresta.alterar.index') }}"> Voltar</a>
                            </div>
                        @elseif(isset($result) && $result === false)
                            <div class="alert alert-danger">
                                Ooops, não foi possível alterar essa aresta. Verifique se ela já não foi inserida antes.
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="usr">I:</label>
                            <input type="text" class="form-control" name="i" value="{{ isset($formData['i']) ? $formData['i'] : '' }}" readonly="true"/>
                        </div>
                        <div class="form-group">
                            <label for="usr">J:</label>
                            <input type="text" class="form-control" name="j" value="{{ isset($formData['j']) ? $formData['j'] : '' }}" readonly="true"/>
                        </div>
                        <div class="form-group">
                            <label for="usr">Peso:</label>
                            <input type="text" class="form-control" name="p" value="{{ isset($formData['p']) ? $formData['p'] : '' }}" {{isset($formData['p']) ? '' : 'readonly="true"'}} />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(!isset($formData['p']))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('aresta.incluir') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Editar aresta</div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if(isset($data) && count($data) > 0)
                                @foreach($data as $aresta)
                                    <a href="{{ route('aresta.alterar.show', ['i' => $aresta['i'], 'j' => $aresta['j']]) }}" class="list-group-item list-group-item-action">
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
    @endif
</div>
@endsection
