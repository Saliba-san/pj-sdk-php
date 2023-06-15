<?php

namespace Inter\Model;

class Paginacao
{
    private $paginaAtual;
    private $itensPorPagina;

    /**
     * Construtor do objeto de Paginação.
     *
     * @param int | null $paginaAtual - Opcional - Página solicitada na request. $paginaAtual = 9  Default: 0<p>
     * @param int | null $itensPorPagina - Opcional - Quantidade de itens desejado por página. $itensPorPagina = 10  Máximo: 1000<p>
     */
    public function __construct(int $paginaAtual = null, int $itensPorPagina = null)
    {
        $this->paginaAtual = $paginaAtual;
        $this->itensPorPagina = $itensPorPagina;
    }

    /**
     * @return int|null
     */
    public function getPaginaAtual()
    {
        return $this->paginaAtual;
    }

    /**
     * @param int $paginaAtual
     */
    public function setPaginaAtual(int $paginaAtual): void
    {
        $this->paginaAtual = $paginaAtual;
    }

    /**
     * @return int|null
     */
    public function getItensPorPagina()
    {
        return $this->itensPorPagina;
    }

    /**
     * @param int $itensPorPagina
     */
    public function setItensPorPagina(int $itensPorPagina): void
    {
        $this->itensPorPagina = $itensPorPagina;
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