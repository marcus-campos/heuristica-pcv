<?php

namespace App\Models;


use Illuminate\Support\Facades\Session;

class Grafo
{

    public function __construct()
    {
        if(!\session()->get('grafo'))
            session()->put('grafo', []);
    }

    /**
     * @return mixed
     */
    public function arestas()
    {
        return \session()->get('grafo');
    }

    /**
     * @param $i
     * @param $j
     * @param $p
     * @return bool
     */
    public function inserirAresta($i, $j, $p)
    {
        if(!$this->validaAresta($i, $j)) {
            \session()->push('grafo',[
                'i' => $i,
                'j' => $j,
                'p' => $p
            ]);

            \session()->push('grafo',[
                'i' => $j,
                'j' => $i,
                'p' => $p
            ]);

            return true;
        }
        else
            return false;
    }

    /**
     * @param $i
     * @param $j
     * @return bool
     */
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

            if($value['j'] == $i and $value['i'] == $j) {
                unset($arestas[$key]);
                $removido = true;
            }
        }

        session()->put('grafo', $arestas);
        return $removido;
    }

    /**
     * @param $i
     * @param $j
     * @return null
     */
    public function pegarAresta($i, $j)
    {
        $arestas = \session()->get('grafo');
        $aresta = null;

        foreach($arestas as $key => $value)
        {
            if($value['i'] == $i and $value['j'] == $j)
                $aresta = $arestas[$key];
        }

        return $aresta;
    }

    /**
     * @param $i
     * @param $j
     * @param $p
     * @return bool
     */
    public function alterarPesoAresta($i, $j, $p)
    {
        $alterado = false;
        $arestas = \session()->pull('grafo');

        if(!$this->validaAresta($i, $j)) {
            foreach ($arestas as $key => $value) {
                if ($value['i'] == $i and $value['j'] == $j) {
                    $arestas[$key]['p'] = $p;
                    $alterado = true;
                }

                if ($value['j'] == $i and $value['i'] == $j) {
                    $arestas[$key]['p'] = $p;
                    $alterado = true;
                }
            }
            session()->put('grafo', $arestas);
        }
        return $alterado;
    }

    public function pcv()
    {
        $visitados = [];
        $arestas = \session()->pull('grafo');

        foreach($arestas as $key => $value) {
            if(!array_key_exists($key, $visitados))
            {
                foreach ($arestas as $k => $v)
                {
                    if(($value['i'] == $v['j'] and $value['j'] == $v['i']) and ($value['p'] < $v['p']))
                        //TODO:terminar
                }
                $visitados[] = $key;
            }
        }
    }

    /**
     * @param $i
     * @param $j
     * @return bool
     */
    private function validaAresta($i, $j)
    {
        $existe = false;
        $arestas = \session()->get('grafo');

        if($arestas)
            foreach ($arestas as $key => $value)
                if($value['i'] == $i and $value['j'] == $j)
                    $existe = true;

        return $existe;
    }

    /**
     *
     */
    public function reiniciar()
    {
        \session()->flush();
    }
}
