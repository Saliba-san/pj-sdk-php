<?php

namespace Inter\Model;

use JsonSerializable;

class Mora implements JsonSerializable
{
    private $codigoMora;
    private $data;
    private $taxa;
    private $valor;

    /**
     * Construtor da classe Multa.
     *
     * @param string $codigoMora - Obrigatório - Código de Mora do título.<p>
     * Valores: <p>
     * . VALORDIA - Valor ao dia<p>
     * . TAXAMENSAL - Taxa mensal<p>
     * . ISENTO - Isento <p>
     * . CONTROLEDOBANCO - Controle do banco
     * @param string | null $data - Opcional ou Obrigatório - Data da Mora do título.p<>
     * Obrigatório se informado código de mora VALORDIA, TAXAMENSAL ou CONTROLEDOBANCO.<p>
     * Deve ser maior que o vencimento e marca a data de início de cobrança<p>
     * de mora (incluindo essa data). $data = "2022-07-01"
     * @param float | null $taxa - Opcional ou Obrigatório - Percentual de Mora do título.<p>
     * Obrigatória se informado código de mora TAXAMENSAL. $taxa = 2.00 <p>
     * @param float | null $valor - Opcional ou Obrigatório -Valor de Mora expresso na moeda do título. <p>
     * Obrigatório se informado código de mora TAXAMENSAL<p>
     * Deve ser 0 para código de mora ISENTO. $valor = 0
     */
    public function __construct(string $codigoMora = null, string $data = null,
                                float  $taxa = null, float $valor = null)
    {
        $this->codigoMora = $codigoMora;
        $this->data = $data;
        $this->taxa = $taxa;
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getCodigoMora()
    {
        return $this->codigoMora;
    }

    /**
     * @param string $codigoMora
     */
    public function setCodigoMora(string $codigoMora): void
    {
        $this->codigoMora = $codigoMora;
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
            'codigoMora' => $this->getCodigoMora(),
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