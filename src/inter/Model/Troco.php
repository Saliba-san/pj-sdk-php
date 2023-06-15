<?php

namespace Inter\Model;

class Troco implements \JsonSerializable
{
    private $valor;
    private $modalidadeAlteracao;
    private $modalidadeAgente;
    private $prestadorDoServicoDeSaque;

    /**
     * Construtor da classe Troco.
     *
     * @param string $valor - Obrigatório - Valor do troco efetuado. $valor = "10.00"<p>
     * @param int $modalidadeAlteracao - Opcional - Modalidade de alteração de valor do troco.<p>
     * Quando não preenchido o valor assumido é o 0 (zero). $modalidadeAlteracao = 0 <p>
     * @param string $prestadorDoServicoDeSaque - Obrigatório - ISPB do Facilitador de Serviço de Saque<p>
     * $prestadorDoServicoDeSaque = "001"<p>
     * @param string $modalidadeAgente - Obrigatório - O campo modalidadeAgente permite as seguintes modalidades:<p>
     * . AGTEC - Agente Estabelecimento Comercial.
     * . AGTOT - Agente Outra Espécie de Pessoa Jurídica ou Correspondente no País.
     */
    public function __construct(string $valor = null, int $modalidadeAlteracao = null,
                                string $modalidadeAgente = null, string $prestadorDoServicoDeSaque = null)
    {
        $this->valor = $valor;
        $this->modalidadeAlteracao = $modalidadeAlteracao;
        $this->modalidadeAgente = $modalidadeAgente;
        $this->prestadorDoServicoDeSaque = $prestadorDoServicoDeSaque;
    }

    /**
     * @return string|null
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     */
    public function setValor(string $valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return int|null
     */
    public function getModalidadeAlteracao()
    {
        return $this->modalidadeAlteracao;
    }

    /**
     * @param int $modalidadeAlteracao
     */
    public function setModalidadeAlteracao(int $modalidadeAlteracao): void
    {
        $this->modalidadeAlteracao = $modalidadeAlteracao;
    }

    /**
     * @return string|null
     */
    public function getModalidadeAgente()
    {
        return $this->modalidadeAgente;
    }

    /**
     * @param string $modalidadeAgente
     */
    public function setModalidadeAgente(string $modalidadeAgente): void
    {
        $this->modalidadeAgente = $modalidadeAgente;
    }

    /**
     * @return string|null
     */
    public function getPrestadorDoServicoDeSaque()
    {
        return $this->prestadorDoServicoDeSaque;
    }

    /**
     * @param string $prestadorDoServicoDeSaque
     */
    public function setPrestadorDoServicoDeSaque(string $prestadorDoServicoDeSaque): void
    {
        $this->prestadorDoServicoDeSaque = $prestadorDoServicoDeSaque;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'valor' => $this->getValor(),
            'modalidadeAlteracao' => $this->getModalidadeAlteracao(),
            'modalidadeAgente' => $this->getModalidadeAgente(),
            'prestadorDoServicoDeSaque' => $this->getPrestadorDoServicoDeSaque()
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