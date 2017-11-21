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
                        @if (isset($result) && $result === true)
                            <div class="alert alert-success">
                                Aresta inserida com sucesso!
                            </div>
                        @elseif(isset($result) && $result === false)
                            <div class="alert alert-danger">
                                Ooops, não foi possível inserir essa aresta. Verifique se ela já não foi inserida antes.
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="usr">I:</label>
                            <input type="text" class="form-control" name="i" required/>
                        </div>
                        <div class="form-group">
                            <label for="usr">J:</label>
                            <input type="text" class="form-control" name="j" required/>
                        </div>
                        <div class="form-group">
                            <label for="usr">Peso:</label>
                            <input type="text" class="form-control" name="p" required/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="par" checked/>
                            Incluir par
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Incluir</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Representação  (para dar zoom use o scrool do mouse)</div>
                <div class="panel-body">
                    <div id="graphDiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
