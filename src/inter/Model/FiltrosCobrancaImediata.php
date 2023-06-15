<?php

namespace Inter\Model;

class FiltrosCobrancaImediata
{
    private $cpf;
    private $cnpj;
    private $status;
    private $locationPresente;

    /**
     * Construtor do objeto de FiltrosCobrancaImediata.
     *
     * @param string | null $cpf - Opcional - Filtro pelo CPF do devedor. Não pode ser utilizado ao mesmo tempo que o CNPJ. $cpf = "48439394058"<p>
     * @param string | null $cnpj - Opcional -Filtro pelo CNPJ do devedor. Não pode ser utilizado ao mesmo tempo que o CPF. $cnpj = "12395678000195"<p>
     * @param bool | null $locationPresente - Opcional -Filtro pelo location. $locationPresente = true<p>
     * @param string | null $status - Opcional - Estado do registro da cobrança. <p>
     * Não se confunde com o estado da cobrança em si, ou seja, não guarda relação com o fato de a cobrança<p>
     * encontrar-se vencida ou expirada,<p>por exemplo.<p>
     * Os status são assim definidos:
     * . ATIVA: indica que o registro se refere a uma cobrança que foi gerada mas ainda não foi paga nem removida;
     * . CONCLUIDA: indica que o registro se refere a uma cobrança que já foi paga e, por conseguinte, não pode acolher outro pagamento;
     * . REMOVIDO_PELO_USUARIO_RECEBEDOR: indica que o usuário recebedor solicitou a remoção do registro da cobrança; e
     * . REMOVIDO_PELO_PSP: indica que o PSP Recebedor solicitou a remoção do registro da cobrança.
     */
    public function __construct(string $cpf = null, string $cnpj = null, bool $locationPresente = null, string $status = null)
    {
        $this->cpf = $cpf;
        $this->cnpj = $cnpj;
        $this->locationPresente = $locationPresente;
        $this->status = $status;

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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool|null
     */
    public function getLocationPresente()
    {
        return $this->locationPresente;
    }

    /**
     * @param bool $locationPresente
     */
    public function setLocationPresente(bool $locationPresente): void
    {
        $this->locationPresente = $locationPresente;
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