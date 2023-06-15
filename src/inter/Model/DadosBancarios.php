<?php

namespace Inter\Model;

class DadosBancarios implements \JsonSerializable
{
    private $contaCorrente;
    private $tipoConta;
    private $cpfCnpj;
    private $agencia;
    private $nome;
    private $tipo;
    private $instituicaoFinanceira;

    /**
     * Construtor do objeto DadosBancarios utilizado no body IncluirPixBody.
     *
     * @param string $contaCorrente - Obrigatório - Conta corrente. $contaCorrente = "48484949"<p>
     * @param string $tipoConta - Obrigatório - Tipo de Conta <p>
     * Valores: <p>
     * . CONTA_CORRENTE<p>
     * . CONTA_POUPANCA<p>
     * . CONTA_SALARIO <p>
     * . CONTA_PAGAMENTO
     * @param string $cpfCnpj - Obrigatório - Cpf ou Cnpj - $cpfCnpj = "37394763890"
     * @param string $agencia - Obrigatório - Agência -  $agencia = "001"<p>
     * @param string $nome - Obrigatório - Nome -  $nome = "Nome"<p>
     * @param InstituicaoFinanceira $instituicaoFinanceira - Obrigatório - Objeto Instituição Financeira<p>
     * @param string $tipo - Obrigatório - Para o caso de DadosBancarios deve ser DADOS_BANCARIOS
     */
    public function __construct(string                $contaCorrente = null, string $tipoConta = null, string $cpfCnpj = null,
                                string                $agencia = null, string $nome = null, string $tipo = null,
                                InstituicaoFinanceira $instituicaoFinanceira = null)
    {
        $this->contaCorrente = $contaCorrente;
        $this->tipoConta = $tipoConta;
        $this->cpfCnpj = $cpfCnpj;
        $this->agencia = $agencia;
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->instituicaoFinanceira = $instituicaoFinanceira;

    }

    /**
     * @return string|null
     */
    final public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    /**
     * @param string $contaCorrente
     */
    final public function setContaCorrente(string $contaCorrente): void
    {
        $this->contaCorrente = $contaCorrente;
    }

    /**
     * @return string|null
     */
    final public function getTipoConta()
    {
        return $this->tipoConta;
    }

    /**
     * @param string $tipoConta
     */
    final public function setTipoConta(string $tipoConta): void
    {
        $this->tipoConta = $tipoConta;
    }

    /**
     * @return string|null
     */
    final public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * @param string $cpfCnpj
     */
    final public function setCpfCnpj(string $cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * @return string|null
     */
    final public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     */
    final public function setAgencia(string $agencia): void
    {
        $this->agencia = $agencia;
    }

    /**
     * @return string|null
     */
    final public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    final public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string|null
     */
    final public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    final public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return InstituicaoFinanceira|null
     */
    final public function getInstituicaoFinanceira()
    {
        return $this->instituicaoFinanceira;
    }

    /**
     * @param InstituicaoFinanceira $instituicaoFinanceira
     */
    final public function setInstituicaoFinanceira(InstituicaoFinanceira $instituicaoFinanceira): void
    {
        $this->instituicaoFinanceira = $instituicaoFinanceira;
    }

    /**
     * Método de jsonSerialize do model.
     */
    final public function jsonSerialize()
    {
        return [
            'contaCorrente' => $this->getContaCorrente(),
            'tipoConta' => $this->getTipoConta(),
            'tipo' => $this->getTipo(),
            'cpfCnpj' => $this->getCpfCnpj(),
            'agencia' => $this->getAgencia(),
            'nome' => $this->getNome(),
            'instituicaoFinanceira' => $this->getInstituicaoFinanceira(),
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "instituicaoFinanceira") {
                $inst = new InstituicaoFinanceira();
                $inst->enricher($value);
                $this->$key = $inst;
            } else {
                $this->$key = $value;
            }
        }
    }
}