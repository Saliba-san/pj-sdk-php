<?php

namespace Inter\Model;

class Retirada implements \JsonSerializable
{
    private $saque;
    private $troco;

    /**
     * Construtor da Classe Retirada.
     *
     * É uma estrutura opcional relacionada ao conceito de recebimento de numerário. <p>
     * Apenas um agrupamento por vez é permitido, quando há saque não há troco e vice-versa.
     *
     * Quando uma cobrança imediata tem uma estrutura de retirada ela deixa de ser considerada Pix comum <p>
     * e passa à categoria de Pix Saque ou Pix Troco.<p>
     *
     * Para que o preenchimento do objeto retirada seja considerado válido as seguintes regras se aplicam:<p>
     *
     * . os campos modalidadeAgente e prestadorDoServicoDeSaque são de preenchimento obrigatório;<p>
     * . quando o saque estiver presente a cobrança deve respeitar as seguintes condições:
     *         . O campo valor.original deve ser preenchido com valor igual a 0.00 (zero);
     *         . O campo valor.modalidadeAlteracao deve possuir o valor 0 (zero) explicitamente, ou implicitamente (pelo não preenchimento).
     * . quando o troco estiver presente a cobrança deve respeitar as seguintes condições:
     *         . O campo valor.original deve ser preenchido com valor maior que 0.00 (zero);
     *         . O campo valor.modalidadeAlteracao deve possuir o valor 0 (zero) explicitamente,
     * ou implicitamente (pelo não preenchimento). <p><p>
     *
     * IMPORTANTE: Quando usados o saque ou troco não será permitida a alteração do valor.original recebido.<p>
     * Na presença de saque ou troco o recebimento do campo valor.modalidadeAlteracao com valor 1 (um)<p>
     * é considerado erro.
     *
     * @param Saque|null $saque - Obrigatório ou Opcional - Objeto Saque. Terá saque quando não há troco.<p>
     * @param Troco|null $troco - Obrigatório ou Opcional- Objeto Troco.Terá troco quando não há saque.
     */
    public function __construct(Saque $saque = null, Troco $troco = null)
    {
        $this->troco = $troco;
        $this->saque = $saque;
    }

    /**
     * @return Saque|null
     */
    public function getSaque()
    {
        return $this->saque;
    }

    /**
     * @param Saque $saque
     */
    public function setSaque(Saque $saque): void
    {
        $this->saque = $saque;
    }

    /**
     * @return Troco
     */
    public function getTroco()
    {
        return $this->troco;
    }

    /**
     * @param Troco $troco
     */
    public function setTroco(Troco $troco): void
    {
        $this->troco = $troco;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'saque' => $this->getSaque(),
            'troco' => $this->getTroco()
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {
            if ($key === "saque") {
                $val = new Saque();
                $val->enricher($value);
                $this->saque = $val;
            } elseif ($key === "troco") {
                $val = new Troco();
                $val->enricher($value);
                $this->troco = $val;
            } else {
                $this->$key = $value;
            }
        }
    }
}