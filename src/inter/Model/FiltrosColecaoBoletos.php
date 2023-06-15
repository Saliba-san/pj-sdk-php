<?php

namespace Inter\Model;

class FiltrosColecaoBoletos extends FiltrosCobranca
{
    private $nossoNumero;

    /**
     * Construtor do objeto de FiltrosColecaoBoletos.
     *
     * @param string | null $cpfCnpj - Opcional - Filtro pelo CPF ou CNPJ. $cpfCnpj = "48439394058"<p>
     * @param string | null $nossoNumero - Opcional -Filtro pelo nossoNumero. $nossoNumero = "00783398490"<p>
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
    public function __construct(string $nossoNumero = null, string $cpfCnpj = null, string $nome = null,
                                string $email = null, string $situacao = null, string $filtrarDataPor = null)
    {
        $this->nossoNumero = $nossoNumero;
        parent::__construct($cpfCnpj, $nome, $email, $situacao, $filtrarDataPor);

    }

    /**
     * @return string|null
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @param string $nossoNumero
     */
    public function setNossoNumero(string $nossoNumero): void
    {
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
        parent::enricher($array);
    }

}