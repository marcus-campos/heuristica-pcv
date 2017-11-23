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
     * @param $nomeI
     * @param $i
     * @param $nomeJ
     * @param $j
     * @param $p
     * @return bool
     */
    public function inserirAresta($nomeI, $i, $nomeJ, $j, $p)
    {
        if(!$this->validaAresta($i, $j)) {

            \session()->push('grafo',[
                'nome' => $nomeI,
                'i' => $i,
                'j' => $j,
                'p' => $p
            ]);

            \session()->push('grafo',[
                'nome' => $nomeJ,
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

        \session()->put('grafo', $arestas);
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

    /**
     * @return array
     */
    public function pcv($verticeInicial)
    {
        $visitados = [];
        $arestas = \session()->get('grafo');
        $verticeAtual = $verticeInicial;

        foreach ($arestas as $aresta) {
            $ligacoes = array_where($arestas, function ($value) use ($verticeAtual, $visitados) {
                if($value['i'] == $verticeAtual)
                    return $value;
            });

            if(($visitado = $this->arestaMenorCusto($ligacoes, $visitados)) != null )
                $visitados[] = $visitado;
            $verticeAtual = array_last($visitados)['j'];
        }

        $ligacoes = array_where($arestas, function ($value) use ($verticeAtual, $visitados) {
            if($value['i'] == $verticeAtual)
                return $value;
        });

        $visitado = $this->arestaMenorCusto($ligacoes, $visitados, $verticeInicial);

        if($visitado != null )
            $visitados[] = $visitado;

        return $visitados;
    }

    /**
     * @param $array
     * @param $visitados
     * @return bool
     */
    private function visitado($array, $visitados, $verticeInicial = null)
    {
        foreach ($visitados as $visitado) {
            if($verticeInicial != null and $array['j'] == $verticeInicial)
                return false;
            if ($visitado == $array or $visitado['i'] == $array['j'] or $visitado['i'] == $array['i'])
                return true;
        }
        return false;
    }

    /**
     * @param $array
     * @return null
     */
    private function arestaMenorCusto($array, $visitados, $verticeInicial = null)
    {
        $ultimoValor = null;
        $aresta = null;
        foreach ($array as $key => $value) {
            if ($ultimoValor == null and !$this->visitado($value, $visitados, $verticeInicial))
                $ultimoValor = $value['p'];
            if ($value['p'] <= $ultimoValor and !$this->visitado($value, $visitados, $verticeInicial)) {
                $ultimoValor = $value['p'];
                $aresta = $value;
            }
        }

        return $aresta;
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

    public function obterNome($j)
    {
        $arestas = \session()->get('grafo');
        return array_first(array_where($arestas, function ($aresta) use ($j) {
            if($aresta['i'] == $j)
                return $aresta;
        }))['nome'];
    }

    public function info($value)
    {
        $arestas = \session()->get('grafo');
        return array_first(array_where($arestas, function ($aresta) use ($value) {
            if($aresta['i'] == $value)
                return $aresta;
        }));
    }
    /**
     *
     */
    public function reiniciar()
    {
        \session()->flush();
    }
}
