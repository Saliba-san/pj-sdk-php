<?php

namespace Inter\Model;

class Chave implements \JsonSerializable
{
    private $chave;
    private $tipo;

    /**
     * Construtor do objeto Chave utilizado no body IncluirPixBody.
     *
     * @param string $chave - Obrigatório - Chave PIX - $chave = "6437373838" <p>
     * @param string $tipo - Obrigatório - Para o caso de PIX deve ser CHAVE
     */
    public function __construct(string $chave = null, string $tipo = null)
    {
        $this->chave = $chave;
        $this->tipo = $tipo;
    }

    /**
     * Retorna o parâmetro $chave.
     */
    final public function getChave()
    {
        return $this->chave;
    }

    /**
     * Altera a chave.
     * @param string $chave - Obrigatório - Novo valor para a chave.<p>
     */
    final public function setChave(string $chave): void
    {
        $this->chave = $chave;
    }

    /**
     * Retorna o parâmetro $tipo.
     */
    final public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Altera o tipo.
     * @param string $tipo - Obrigatório - Novo valor para o tipo.<p>
     */
    final public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * Método de jsonSerialize do model.
     */
    final public function jsonSerialize()
    {
        return [
            'chave' => $this->getChave(),
            'tipo' => $this->getTipo(),
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