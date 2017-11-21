<?php


Route::get('/', function () {
    return redirect()->to(route('aresta.incluir'));
})->name('index');

Route::group(['prefix' => 'aresta', 'as' => 'aresta.'], function () {
    Route::get('incluir', function () {
        return view('incluir');
    })->name('index');

    Route::post('incluir', function (\Illuminate\Http\Request $request) {
        $result = (new \App\Models\Grafo())->inserirAresta($request->i, $request->j, $request->p, $request->par);
        return view('incluir', compact('result'));
    })->name('incluir');

    Route::get('remover', function () {
        $data = (new \App\Models\Grafo())->arestas();
        return view('remover', compact('data'));
    })->name('remover.index');

    Route::get('remover/{i}/{j}', function (\Illuminate\Http\Request $request){
        $result = (new \App\Models\Grafo())->removerAresta($request->i, $request->j);
        return view('remover', compact('result'));
    })->name('remover');

    Route::get('exibir', function () {
        $data = (new \App\Models\Grafo())->arestas();
        return view('exibir', compact('data'));
    })->name('exibir');

    Route::get('alterar', function () {
        $data = (new \App\Models\Grafo())->arestas();
        return view('alterar', compact('data'));
    })->name('alterar.index');

    Route::get('alterar/{i}/{j}', function (\Illuminate\Http\Request $request) {
        $formData = (new \App\Models\Grafo())->pegarAresta($request->i, $request->j);
        return view('alterar', compact('formData'));
    })->name('alterar.show');

    Route::post('alterar', function (\Illuminate\Http\Request $request) {
        $result = (new \App\Models\Grafo())->alterarPesoAresta($request->i, $request->j, $request->p);
        return view('alterar', compact('result'));
    })->name('alterar');

    Route::get('pcv', function () {
        $data = (new \App\Models\Grafo())->arestas();
        $verticeInicial = array_first($data)['i'];
        $pcv = (new \App\Models\Grafo())->pcv($verticeInicial);
        return view('pcv', compact('pcv', 'data', 'verticeInicial'));
    })->name('pcv');

    Route::post('pcv', function (\Illuminate\Http\Request $request) {
        $pcv = (new \App\Models\Grafo())->pcv($request->verticeInicial);
        $data = (new \App\Models\Grafo())->arestas();
        $verticeInicial = $request->verticeInicial;
        return view('pcv', compact('pcv', 'data', 'verticeInicial'));
    })->name('pcv.vertice');

    Route::get('reiniciar', function () {
        (new \App\Models\Grafo())->reiniciar();
        return redirect()->to('/');
    })->name('reiniciar');
});