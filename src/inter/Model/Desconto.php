<?php

namespace Inter\Model;

use JsonSerializable;

class Desconto implements JsonSerializable
{
    private $codigoDesconto;
    private $data;
    private $taxa;
    private $valor;

    /**
     * Construtor da classe Desconto.
     *
     * @param string $codigoDesconto - Obrigatório - Código de Desconto do título.<p>
     * Valores: <p>
     * . NAOTEMDESCONTO - Não tem desconto.<p>
     * . VALORFIXODATAINFORMADA - Valor fixo até a data informada.<p>
     * . PERCENTUALDATAINFORMADA - Percentual até a data informada. <p>
     * . VALORANTECIPACAODIACORRIDO - Valor por antecipação dia corrido. <p>
     * . VALORANTECIPACAODIAUTIL - Valor por antecipação dia útil. <p>
     * . PERCENTUALVALORNOMINALDIACORRIDO - Percentual sobre o valor nominal dia corrido. <p>
     * . PERCENTUALVALORNOMINALDIAUTIL - Percentual sobre o valor nominal dia útil.<p>
     * @param string | null $data - Opcional ou Obrigatório - Data de Desconto do título.<p>
     * Obrigatório para códigos de desconto VALORFIXODATAINFORMADA e PERCENTUALDATAINFORMADA.<p>
     * Não informar para os demais. $data = "2022-07-01"
     * @param float | null $taxa - Opcional ou Obrigatório - Taxa Percentual de Desconto do título. <p>
     * Obrigatório para códigos de desconto PERCENTUALDATAINFORMADA, PERCENTUALVALORNOMINALDIACORRIDO <p>
     * e PERCENTUALVALORNOMINALDIAUTIL. $taxa = 3.00<p>
     * @param float | null $valor - Opcional ou Obrigatório - Valor de Desconto, expresso na moeda do título. <p>
     * Obrigatório para códigos de desconto VALORFIXODATAINFORMADA, VALORANTECIPACAODIACORRIDO<p>
     * e VALORANTECIPACAODIAUTIL. $valor = 4.00
     */
    public function __construct(string $codigoDesconto = null, string $data = null,
                                float  $taxa = null, float $valor = null)
    {
        $this->codigoDesconto = $codigoDesconto;
        $this->data = $data;
        $this->taxa = $taxa;
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getCodigoDesconto()
    {
        return $this->codigoDesconto;
    }

    /**
     * @param string $codigoDesconto
     */
    public function setCodigoDesconto(string $codigoDesconto): void
    {
        $this->codigoDesconto = $codigoDesconto;
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
            'codigoDesconto' => $this->getCodigoDesconto(),
            'data' => $this->getData(),
            'taxa' => $this->getTaxa(),
            'valor' => $this->getValor(),
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