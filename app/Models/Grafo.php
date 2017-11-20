<?php

namespace App\Models;


use Illuminate\Support\Facades\Session;

class Grafo
{

    public function __construct()
    {
        if(!\session()->get('grafo'))
            \session()->put('grafo', []);
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
     * @param $par
     * @return bool
     */
    public function inserirAresta($i, $j, $p, $par)
    {
        if(!$this->validaAresta($i, $j)) {
            if($par == 'on')
                \session()->push('grafo',[
                    'i' => $j,
                    'j' => $i,
                    'p' => $p
                ]);

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
            }
            session()->put('grafo', $arestas);
        }
        return $alterado;
    }

    /**
     * @return array
     */
    public function pcv()
    {
        $visitados = [];
        $arestas = \session()->get('grafo');

        foreach($arestas as $key => $value) {
            $estado = [];
            if (!array_where($visitados, function ($visitado) use ($value) {
                if ($value == $visitado)
                    return true;
                return false;
            }))
                foreach ($arestas as $k => $v)
                    if(empty($atual))
                        if ($value['i'] == $v['j'] and $v['p'] < $value['p']) {
                            $estado[] = $v;
                            foreach ($estado as $item)
                            {
                                if ($v['i'] == $item['j'] and $item['p'] < $v['p'])
                                    $visitados = $item;
                            }
                        }


        }

        return $visitados;
    }

    /**
     * @param $array
     * @return array
     */
    private function arrayInvert($array)
    {
        return [
            'i' => $array['j'],
            'j' => $array['i'],
            'p' => $array['p']
        ];
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
