<?php

namespace Inter\Model;

class Violacao
{
    public $razao;
    public $propriedade;
    public $valor;

    public function __construct(string $razao = '', string $propriedade = '', string $valor = '')
    {
        $this->valor = $valor;
        $this->propriedade = $propriedade;
        $this->razao = $razao;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getPropriedade() {
        return $this->propriedade;
    }

    public function getRazao() {
        return $this->razao;
    }

}