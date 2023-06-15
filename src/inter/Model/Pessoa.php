<?php

namespace Inter\Model;

use JsonSerializable;

class Pessoa implements JsonSerializable
{
    private $cpfCnpj;
    private $tipoPessoa;
    private $nome;
    private $endereco;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $uf;
    private $cep;
    private $email;
    private $ddd;
    private $telefone;

    /**
     * Construtor da classe Pessoa.
     *
     * @param string $cpfCnpj - Obrigatório - CPF/CNPJ do pagador ou beneficiário do título. <p>
     * CNPJ: NNNNNNNNNFFFFCC<p>
     * CPF : 0000NNNNNNNNNCC,<p>
     * onde NNNNNNNNN é a raiz do CNPJ/CPF<p>
     * FFFF = filial do CNPJ<p>
     * CC = dígitos de controle
     * @param string $tipoPessoa - Obrigatório - Tipo do pagador ou beneficiário. <p>
     * Valores: <p>
     * . FISICA - Pessoa Física <p>
     * . JURIDICA - Pessoa Jurídica <p>
     * @param string $nome - Obrigatório - Nome do pagador ou beneficiário. $nome = "Rafael."
     * @param string $endereco - Obrigatório - Endereço do pagador ou beneficiário. $endereco = "Avenida Brasil"
     * @param string | null $numero - Opcional - Número do logradouro do pagador ou beneficiário. $numero = "5"
     * @param string | null $complemento - Opcional - Complemento do endereço do pagador ou beneficiário. $complemento = "Casa"
     * @param string | null $bairro - Opcional ou Obrigatório - Bairro do pagador ou beneficiário.<p>
     * Obrigatório no caso da pessoa ser o beneficiário do título. $bairro = "Santo Agostinho"
     * @param string $cidade - Obrigatório - Cidade do pagador ou beneficiário. $cidade = "Belo Horizonte"
     * @param string $uf - Obrigatório - UF do pagador ou beneficiário. $cidade = "MG"
     * @param string $cep - Obrigatório - CEP do pagador ou beneficiário. $cep = "34596749"
     * @param string | null $email - Opcional - Email do pagador ou beneficiário. $email = "meu@email.com"
     * @param string | null $ddd - Opcional - ddd do pagador ou beneficiário. $ddd = "31"
     * @param string | null $telefone - Opcional - Telefone do pagador ou beneficiário. $telefone = "984735839"
     */
    public function __construct(string $cpfCnpj = null, string $tipoPessoa = null, string $nome = null, string $endereco = null,
                                string $numero = null, string $complemento = null, string $bairro = null, string $cidade = null,
                                string $uf = null, string $cep = null, string $email = null, string $ddd = null,
                                string $telefone = null)
    {
        $this->cpfCnpj = $cpfCnpj;
        $this->tipoPessoa = $tipoPessoa;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->cep = $cep;
        $this->email = $email;
        $this->ddd = $ddd;
        $this->telefone = $telefone;
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
     * @return string|null
     */
    public function getTipoPessoa()
    {
        return $this->tipoPessoa;
    }

    /**
     * @param string $tipoPessoa
     */
    public function setTipoPessoa(string $tipoPessoa): void
    {
        $this->tipoPessoa = $tipoPessoa;
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
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param string $endereco
     */
    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }

    /**
     * @return string|null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return string|null
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param string $complemento
     */
    public function setComplemento(string $complemento): void
    {
        $this->complemento = $complemento;
    }

    /**
     * @return string|null
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param string $bairro
     */
    public function setBairro(string $bairro): void
    {
        $this->bairro = $bairro;
    }

    /**
     * @return string|null
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param string $cidade
     */
    public function setCidade(string $cidade): void
    {
        $this->cidade = $cidade;
    }

    /**
     * @return string|null
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param string $uf
     */
    public function setUf(string $uf): void
    {
        $this->uf = $uf;
    }

    /**
     * @return string|null
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param string $cep
     */
    public function setCep(string $cep): void
    {
        $this->cep = $cep;
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
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @param string $ddd
     */
    public function setDdd(string $ddd): void
    {
        $this->ddd = $ddd;
    }

    /**
     * @return string|null
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'cpfCnpj' => $this->getCpfCnpj(),
            'tipoPessoa' => $this->getTipoPessoa(),
            'endereco' => $this->getEndereco(),
            'numero' => $this->getNumero(),
            'complemento' => $this->getComplemento(),
            'bairro' => $this->getBairro(),
            'cidade' => $this->getCidade(),
            'uf' => $this->getUf(),
            'cep' => $this->getCep(),
            'email' => $this->getEmail(),
            'ddd' => $this->getDdd(),
            'telefone' => $this->getTelefone(),
            'nome' => $this->getNome()
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