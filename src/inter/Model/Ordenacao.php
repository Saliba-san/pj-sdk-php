<?php

namespace Inter\Model;

class Ordenacao
{
    private $ordenarPor;
    private $tipoOrdenacao;

    /**
     * Construtor do objeto de Ordenação.
     *
     * @param string | null $ordenarPor - Opcional - Ordenar resultado por: <p>
     * . PAGADOR (Deafult)<p>
     * . NOSSONUMERO <p>
     * . SEUNUMERO <p>
     * . DATASITUACAO <p>
     * . DATAVENCIMENTO <p>
     * . VALOR <p>
     * . STATUS <p>
     * @param string | null $tipoOrdenacao - Opcional - Ordenação em ordem: <p>
     * . ASC (Default) <p>
     * . DESC
     */
    public function __construct(string $ordenarPor = null, string $tipoOrdenacao = null)
    {
        $this->ordenarPor = $ordenarPor;
        $this->tipoOrdenacao = $tipoOrdenacao;
    }

    /**
     * @return string|null
     */
    public function getOrdenarPor()
    {
        return $this->ordenarPor;
    }

    /**
     * @param string $ordenarPor
     */
    public function setOrdenarPor(string $ordenarPor): void
    {
        $this->ordenarPor = $ordenarPor;
    }

    /**
     * @return string|null
     */
    public function getTipoOrdenacao()
    {
        return $this->tipoOrdenacao;
    }

    /**
     * @param string $tipoOrdenacao
     */
    public function setTipoOrdenacao(string $tipoOrdenacao): void
    {
        $this->tipoOrdenacao = $tipoOrdenacao;
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

}