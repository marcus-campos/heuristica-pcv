<?php

namespace App\Models;


use Illuminate\Support\Facades\Session;

class Grafo
{
    private $grafo;

    public function __construct()
    {
        if(\session()->get('grafo'))
            $this->grafo = Session::get('grafo');
        else
            \session()->put('grafo', []);
    }

    public function arestas()
    {
        return \session()->get('grafo');
    }

    public function inserirAresta($i, $j, $p)
    {
        if(!$this->validaAresta($i, $j)) {
            \session()->push('grafo',[
                'i' => $i,
                'j' => $j,
                'p' => $p
            ]);

            return true;
        }
        else
            return false;
    }

    public function removerAresta($i, $j)
    {
        $removido = false;
        $arestas = \session()->pull('grafo');

        foreach($arestas as $key => $value)
        {
            if($value['i'] == $i and $value['j'] == $j) {
                unset($arestas[$key]);
                $removido = true;
            }
        }

        session()->put('grafo', $arestas);
        return $removido;
    }

    private function validaAresta($i, $j)
    {
        $existe = false;
        $grafo = \session()->get('grafo');

        if($grafo)
            foreach ($grafo as $key => $value)
                if($value == $i or $value == $j)
                    $existe = true;

        return $existe;
    }

    public function reiniciar()
    {
        \session()->flush();
    }
}
