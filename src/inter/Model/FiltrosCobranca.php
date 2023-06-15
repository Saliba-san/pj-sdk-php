<?php

namespace Inter\Model;

class FiltrosCobranca
{
    private $cpfCnpj;
    private $email;
    private $nome;
    private $situacao;
    private $filtrarDataPor;

    /**
     * Construtor do objeto de FiltrosCobranca.
     *
     * @param string | null $cpfCnpj - Opcional - Filtro pelo CPF ou CNPJ. $cpfCnpj = "48439394058"<p>
     * @param string | null $nome - Opcional -Filtro pelo nome. $nome = "Rafael"<p>
     * @param string | null $email - Opcional -Filtro pelo email. $email = "email$email.com"<p>
     * @param string | null $situacao - Opcional - Filtro pela situação da cobrança.<p>
     * Valores: <p>
     * . EXPIRADO<p>
     * . VENCIDO<p>
     * . EMABERTO<p>
     * . PAGO<p>
     * . CANCELADO<p>
     * OBS: No caso de filtrar por mais de uma situação, as situações devem ser separadas por vírgula<p>
     * (PAGO,EMABERTO,VENCIDO)
     * @param string | null $filtrarDataPor - Opcional - Os filtros de data inicial e data final se aplicarão a:<p>
     * . VENCIMENTO - Filtro de data pelo vencimento. (Default)<p>
     * . EMISSAO - Filtro de data pela emissão. <p>
     * . SITUACAO - Filtro de data pela mudança de situação.<p>
     * Caso o campo situacao seja: <p>
     * . EXPIRADO as datas corresponderão a data de expiração dos boletos;<p>
     * . VENCIDO as datas corresponderão a data de vencimento dos boletos;<p>
     * . EMABERTO as datas corresponderão a data de emissão dos boletos;<p>
     * . PAGO as datas corresponderão a data de pagamento dos boletos;<p>
     * . CANCELADO as datas corresponderão a data de cancelamento dos boletos;<p>
     */
    public function __construct(string $cpfCnpj = null, string $nome = null,
                                string $email = null, string $situacao = null,
                                string $filtrarDataPor = null)
    {
        $this->cpfCnpj = $cpfCnpj;
        $this->email = $email;
        $this->nome = $nome;
        $this->situacao = $situacao;
        $this->filtrarDataPor = $filtrarDataPor;

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
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param string $situacao
     */
    public function setSituacao(string $situacao): void
    {
        $this->situacao = $situacao;
    }

    /**
     * @return string|null
     */
    public function getFiltrarDataPor()
    {
        return $this->filtrarDataPor;
    }

    /**
     * @param string $filtrarDataPor
     */
    public function setFiltrarDataPor(string $filtrarDataPor): void
    {
        $this->filtrarDataPor = $filtrarDataPor;
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key !== "nossoNumero") {
                $this->$key = $value;
            }
        }
    }

}