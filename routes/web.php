<?php


Route::get('/', function () {
    return redirect()->to(route('aresta.incluir'));
})->name('index');

Route::group(['prefix' => 'aresta', 'as' => 'aresta.'], function () {
    Route::get('incluir', function () {
        return view('incluir');
    })->name('index');

    Route::post('incluir', function (\Illuminate\Http\Request $request) {
        $result = (new \App\Models\Grafo())->inserirAresta($request->i, $request->j, $request->p);
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

    Route::get('reiniciar', function () {
        (new \App\Models\Grafo())->reiniciar();
        return redirect()->to('/');
    })->name('reiniciar');
});