<?php

namespace Inter\Model;

class CobrancaBody implements \JsonSerializable
{
    private $calendario;
    private $devedor;
    private $loc;
    private $valor;
    private $chave;
    private $solicitacaoPagador;
    private $infoAdicionais;

    /**
     * Construtor do Body do método criarCobrancaImediata.
     *
     * @param Calendario $calendario - Obrigatório - Objeto Calendário.<p>
     * @param Valor $valor - Obrigatório - Objeto Valor - Valores monetários referentes à cobrança.
     * @param string $chave - Obrigatório - O campo chave determina a chave Pix do recebedor que foi utilizada para as cobranças.<p>
     * Os tipos de chave podem ser: telefone, e-mail, cpf/cnpj ou EVP.<p>
     * O formato das chaves pode ser encontrado na seção "Formatação das chaves do DICT no BR Code" do Manual de Padrões para iniciação do Pix. <p>
     * Consulte: https://www.bcb.gov.br/estabilidadefinanceira/pix<p>
     * @param Devedor | null $devedor - Opcional - Objeto Devedor
     * @param array | null $infoAdicionais - Opcional - Array de Objetos InfoAdicional <p>
     * @param Loc | null $loc - Opcional - Objeto Loc
     * @param string | null $solicitacaoPagador - Opcional - O campo solicitacaoPagador determina um texto <p>
     * a ser apresentado ao pagador para que ele possa digitar uma informação correlata,<p>
     * em formato livre, a ser enviada ao recebedor. Esse texto está limitado a 140 caracteres.<p>
     * $solicitacaoPagador = "Serviço Realizado"
     */
    public function __construct(Calendario $calendario = null, Valor $valor = null, string $chave = null,
                                Devedor    $devedor = null, array $infoAdicionais = [], Loc $loc = null,
                                string     $solicitacaoPagador = null)
    {
        $this->calendario = $calendario;
        $this->devedor = $devedor;
        $this->loc = $loc;
        $this->valor = $valor;
        $this->solicitacaoPagador = $solicitacaoPagador;
        $this->chave = $chave;
        $this->infoAdicionais = $infoAdicionais;

    }

    /**
     * @return Calendario|null
     */
    public function getCalendario()
    {
        return $this->calendario;
    }

    /**
     * @param Calendario $calendario
     */
    public function setCalendario(Calendario $calendario): void
    {
        $this->calendario = $calendario;
    }

    /**
     * @return Devedor|null
     */
    public function getDevedor()
    {
        return $this->devedor;
    }

    /**
     * @param Devedor $devedor
     */
    public function setDevedor(Devedor $devedor): void
    {
        $this->devedor = $devedor;
    }

    /**
     * @return Loc|null
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @param Loc $loc
     */
    public function setLoc(Loc $loc): void
    {
        $this->loc = $loc;
    }

    /**
     * @return Valor|null
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param Valor $valor
     */
    public function setValor(Valor $valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return string|null
     */
    public function getChave()
    {
        return $this->chave;
    }

    /**
     * @param string $chave
     */
    public function setChave(string $chave): void
    {
        $this->chave = $chave;
    }

    /**
     * @return string|null
     */
    public function getSolicitacaoPagador()
    {
        return $this->solicitacaoPagador;
    }

    /**
     * @param string $solicitacaoPagador
     */
    public function setSolicitacaoPagador(string $solicitacaoPagador): void
    {
        $this->solicitacaoPagador = $solicitacaoPagador;
    }

    /**
     * @return array|null
     */
    public function getInfoAdicionais()
    {
        return $this->infoAdicionais;
    }

    /**
     * @param array $infoAdicionais
     */
    public function setInfoAdicionais(array $infoAdicionais): void
    {
        $this->infoAdicionais = $infoAdicionais;
    }

    /**
     * Método de jsonSerialize do model.
     */
    public function jsonSerialize()
    {
        return [
            'calendario' => $this->getCalendario(),
            'devedor' => $this->getDevedor(),
            'loc' => $this->getLoc(),
            'valor' => $this->getValor(),
            'chave' => $this->getChave(),
            'solicitacaoPagador' => $this->getSolicitacaoPagador(),
            'infoAdicionais' => $this->getInfoAdicionais()
        ];
    }

    /**
     * Método de enricher do model.
     */
    public function enricher($array)
    {
        foreach ($array as $key => $value) {

            if ($key === "calendario") {
                $cal = new Calendario();
                $cal->enricher($value);
                $this->calendario = $cal;
            } elseif ($key === "devedor") {
                $dev = new Devedor();
                $dev->enricher($value);
                $this->devedor = $dev;
            } elseif ($key === "loc") {
                $l = new Loc();
                $l->enricher($value);
                $this->loc = $l;
            } elseif ($key === "valor") {
                $val = new Valor();
                $val->enricher($value);
                $this->valor = $val;
            } elseif ($key === "infoAdicionais") {

                foreach ($value as $infoAdicional) {
                    $info = new InfoAdicional();
                    $info->enricher($infoAdicional);
                    $infos[] = $info;
                }

                $this->infoAdicionais = $infos;

            } else {
                $this->$key = $value;
            }
        }
    }


}