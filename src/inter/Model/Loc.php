<?php

namespace Inter\Model;

class Loc implements \JsonSerializable
{
    private $tipoCob;

    /**
     * Construtor da classe Loc.
     *
     * @param string $tipoCob - Obrigatório - Tipo de cob<p>
     * Valores: <p>
     * . cob<p>
     * . cobv
     */
    public function __construct(string $tipoCob = null)
    {
        $this->tipoCob = $tipoCob;
    }

    /**
     * @return string|null
     */
    public function getTipoCob()
    {
        return $this->tipoCob;
    }

    /**
     * @param string $tipoCob
     */
    public function setTipoCob(string $tipoCob): void
    {
        $this->tipoCob = $tipoCob;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'tipoCob' => $this->getTipoCob()
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