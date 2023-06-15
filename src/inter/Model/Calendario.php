<?php

namespace Inter\Model;

class Calendario implements \JsonSerializable
{
    private $expiracao;

    /**
     * Construtor da classe Calendário.
     *
     * @param int $expiracao - Obrigatório - Tempo de vida da cobrança, especificado em segundos a partir da data<p>
     * de criação (new Calendario($expiracao)). $expiracao = 86400<p>
     */
    public function __construct(int $expiracao = null)
    {
        $this->expiracao = $expiracao;
    }

    /**
     * @return int|null
     */
    public function getExpiracao()
    {
        return $this->expiracao;
    }

    /**
     * @param int $expiracao
     */
    public function setExpiracao(int $expiracao): void
    {
        $this->expiracao = $expiracao;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'expiracao' => $this->getExpiracao()
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