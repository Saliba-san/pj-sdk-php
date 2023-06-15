<?php

namespace Inter\Model;

use JsonSerializable;

class Multa implements JsonSerializable
{
    private $codigoMulta;
    private $data;
    private $taxa;
    private $valor;

    /**
     * Construtor da classe Multa.
     *
     * @param string $codigoMulta - Obrigatório - Código de Multa do título.<p>
     * Valores: <p>
     * . NAOTEMMULTA - Não tem multa<p>
     * . VALORFIXO – Valor fixo <p>
     * . PERCENTUAL - Percentual
     * @param string | null $data - Opcional ou Obrigatório - Data de Multa do título.<p>
     * Obrigatório para códigos de multa VALORFIXO ou PERCENTUAL.<p>
     * Deve ser maior que o vencimento e marca a data de início de cobrança de multa<p>
     * (incluindo essa data). $data = "2022-07-01"
     * @param float | null $taxa - Opcional ou Obrigatório - Taxa Percentual de Multa do título.<p>
     * Obrigatória se informado código de multa PERCENTUAL. <p>
     * Deve ser 0 para código de multa NAOTEMMULTA. $taxa = 2.00
     * @param float | null $valor - Opcional ou Obrigatório - Valor de Multa expresso na moeda do título. <p>
     * Obrigatório se informado código de multa VALORFIXO<p>
     * Deve ser 0 para código de multa NAOTEMMULTA. $valor = 0<p>
     */
    public function __construct(string $codigoMulta = null, string $data = null,
                                float  $taxa = null, float $valor = null)
    {
        $this->codigoMulta = $codigoMulta;
        $this->data = $data;
        $this->taxa = $taxa;
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getCodigoMulta()
    {
        return $this->codigoMulta;
    }

    /**
     * @param string $codigoMulta
     */
    public function setCodigoMulta(string $codigoMulta): void
    {
        $this->codigoMulta = $codigoMulta;
    }

    /**
     * @return string|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return float|null
     */
    public function getTaxa()
    {
        return $this->taxa;
    }

    /**
     * @param float $taxa
     */
    public function setTaxa(float $taxa): void
    {
        $this->taxa = $taxa;
    }

    /**
     * @return float|null
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'codigoMulta' => $this->getCodigoMulta(),
            'data' => $this->getData(),
            'taxa' => $this->getTaxa(),
            'valor' => $this->getValor()
        ];
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