<?php

namespace Inter\Model;

class InfoAdicional implements \JsonSerializable
{
    private $nome;
    private $valor;

    /**
     * Construtor da classe InfoAdicional.
     *
     * @param string $nome - Obrigatório - Nome do campo. $nome = "Idade"<p>
     * @param string $valor - Obrigatório - Valor do campo. $nome = "18 anos"<p>
     */
    public function __construct(string $nome = null, string $valor = null)
    {
        $this->nome = $nome;
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
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
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'nome' => $this->getNome(),
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