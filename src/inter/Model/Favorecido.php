<?php

namespace Inter\Model;

class Favorecido implements \JsonSerializable
{
    private $id;
    private $nome;
    private $cpfCnpj;
    private $instituicaoFinanceira;
    private $agencia;
    private $conta;
    private $email;
    private $descricao;

    /**
     * Construtor do objeto Favorecido.
     *
     * @param int | null $id - Opcional - Id do favorecido. $id = 5 <p>
     * @param string $nome - Obrigatório - Nome do Favorecido. $nome = "Nome" <p>
     * @param string | null $cpfCnpj - Opcional - CPF/CNPJ do favorecido - $cpfCnpj = "37492274927"
     * @param InstituicaoFinanceira $instituicaoFinanceira - Obrigatório - Objeto InstituicaoFinanceira <p>
     * @param string $agencia - Obrigatório - Código da agência. $agencia = "001" <p>
     * @param string $conta - Obrigatório - Número da conta. $conta = "1895011" <p>
     * @param string | null $email - Opcional - Email do favorecido - $email = "examplo@email.com"
     * @param string | null $descricao - Opcional - Descricao para o favorecido - $descricao = "Descrição"
     */
    public function __construct(int    $id = null, string $nome = null, string $cpfCnpj = null, InstituicaoFinanceira $instituicaoFinanceira = null,
                                string $agencia = null, string $conta = null, string $email = null, string $descricao = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpfCnpj = $cpfCnpj;
        $this->instituicaoFinanceira = $instituicaoFinanceira;
        $this->agencia = $agencia;
        $this->conta = $conta;
        $this->email = $email;
        $this->descricao = $descricao;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * @param string $cpfCnpj
     */
    public function setCpfCnpj(string $cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * @return InstituicaoFinanceira|null
     */
    public function getInstituicaoFinanceira()
    {
        return $this->instituicaoFinanceira;
    }

    /**
     * @param InstituicaoFinanceira $instituicaoFinanceira
     */
    public function setInstituicaoFinanceira(InstituicaoFinanceira $instituicaoFinanceira): void
    {
        $this->instituicaoFinanceira = $instituicaoFinanceira;
    }

    /**
     * @return string|null
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     */
    public function setAgencia(string $agencia): void
    {
        $this->agencia = $agencia;
    }

    /**
     * @return string|null
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param string $conta
     */
    public function setConta(string $conta): void
    {
        $this->conta = $conta;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'cpfCnpj' => $this->getCpfCnpj(),
            'instituicaoFinanceira' => $this->getInstituicaoFinanceira(),
            'agencia' => $this->getAgencia(),
            'conta' => $this->getConta(),
            'email' => $this->getEmail(),
            'descricao' => $this->getDescricao(),
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "instituicaoFinanceira") {
                $instituicao = new InstituicaoFinanceira();
                $instituicao->enricher($value);
                $this->$key = $instituicao;
            } else {
                $this->$key = $value;
            }

        }
    }
}