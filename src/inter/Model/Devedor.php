<?php

namespace Inter\Model;

class Devedor implements \JsonSerializable
{
    private $cpf;
    private $cnpj;
    private $nome;

    /**
     * Construtor do objeto de Devedor.
     *
     * @param string | null $cpf - Opcional ou Obrigatório - CPF do usuário. $cpf = "48502274903"<p>
     * O CPF é obrigatório quando o usuário é uma pessoa física. Nesse caso, o cnpj deve ser nulo.
     * @param string | null $cnpj - Opcional - CNPJ do usuário. $cnpj = "12395678000195"<p>
     * O CNPJ é obrigatório quando o usuário é uma pessoa jurídica. Nesse caso, o cpf deve ser nulo.
     * @param string $nome - Obrigatório - Nome do usuário. $nome = "Rafael"<p>
     */
    public function __construct(string $nome = null, string $cpf = null, string $cnpj = null)
    {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->cnpj = $cnpj;
    }

    /**
     * @return string|null
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string|null
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
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
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'cpf' => $this->getCpf(),
            'cnpj' => $this->getCnpj(),
            'nome' => $this->getNome(),
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