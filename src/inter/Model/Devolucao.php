<?php

namespace Inter\Model;

class Devolucao implements \JsonSerializable
{
    private $valor;
    private $natureza;
    private $descricao;

    /**
     * Construtor do objeto de Devolucao.
     *
     * @param string $valor - Obrigatório - Valor solicitado para devolução.<p>
     * A soma dos valores de todas as devolucões não podem ultrapassar o valor total do Pix. <p>
     * $valor = "7.89"<p>
     * @param string $descricao - Opcional - O campo descricao, opcional, determina um texto a ser apresentado<p>
     * ao pagador contendo informações sobre a devolução. Esse texto será preenchido,<p>
     * na pacs.004, pelo PSP do recebedor, no campo RemittanceInformation.<p>
     * O tamanho do campo na pacs.004 está limitado a 140 caracteres.<p>
     * $descricao = "Descrição"
     * @param string $natureza - Opcional - Indica qual é a natureza da devolução solicitada. <p>
     * Uma solicitação de devolução pelo usuário recebedor pode ser relacionada a um Pix<p>
     * comum (com código: MD06 da pacs.004), ou a um Pix de Saque ou Troco (com códigos possíveis: <p>
     * MD06 e SL02 da pacs.004). Na ausência deste campo a natureza deve ser interpretada como sendo de<p>
     * um Pix comum (ORIGINAL).<p><p>
     * As naturezas são assim definidas:<p>
     * . ORIGINAL: quando a devolução é solicitada pelo usuário recebedor e se refere a um Pix<p>
     * comum ou ao valor da compra em um Pix Troco (MD06);<p>
     * . RETIRADA: quando a devolução é solicitada pelo usuário recebedor e se refere a um Pix Saque<p>
     * ou ao valor do troco em um Pix Troco (SL02).<p><p>
     * Os valores de devoluções são sempre limitados aos valores máximos a seguir:<p>
     * . Pix comum: o valor da devolução é limitado ao valor do próprio Pix <p>
     * (a natureza nesse caso deve ser: ORIGINAL);<p>
     * . Pix Saque: o valor da devolução é limitado ao valor da retirada <p>
     * (a natureza nesse caso deve ser: RETIRADA); e<p>
     * . Pix Troco: o valor da devolução é limitado ao valor relativo à compra ou ao troco:<p>
     *          .Quando a devolução for referente à compra, o valor limita-se ao valor da compra <p>
     *          (a natureza nesse caso deve ser ORIGINAL); e<
     *          . Quando a devolução for referente ao troco, o valor limita-se ao valor do troco
     *            (a natureza nesse caso deve ser RETIRADA).
     */
    public function __construct(string $valor = null, string $natureza = null, string $descricao = null)
    {
        $this->valor = $valor;
        $this->natureza = $natureza;
        $this->descricao = $descricao;
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
     * @return string|null
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * @param string $natureza
     */
    public function setNatureza(string $natureza): void
    {
        $this->natureza = $natureza;
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
            'valor' => $this->getValor(),
            'natureza' => $this->getNatureza(),
            'descricao' => $this->getDescricao(),
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