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
                        @if (isset($result))
                            <div class="alert alert-success">
                                Aresta inserida com sucesso!
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="usr">I:</label>
                            <input type="text" class="form-control" name="i"/>
                        </div>
                        <div class="form-group">
                            <label for="usr">J:</label>
                            <input type="text" class="form-control" name="j"/>
                        </div>
                        <div class="form-group">
                            <label for="usr">Peso:</label>
                            <input type="text" class="form-control" name="p"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Incluir</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
