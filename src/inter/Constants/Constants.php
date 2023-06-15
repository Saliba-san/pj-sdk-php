<?php

namespace Inter\Constants;

define("SCOPE_EXTRATO_READ", "extrato.read");
define("SCOPE_BOLETO_READ", "pagamento-boleto.read");
define("SCOPE_BOLETO_WRITE", "pagamento-boleto.write");
define("SCOPE_BOLETO_COBRANCA_READ", "boleto-cobranca.read");
define("SCOPE_BOLETO_COBRANCA_WRITE", "boleto-cobranca.write");
define("SCOPE_PAGAMENTO_PIX_READ", "pagamento-pix.read");
define("SCOPE_PAGAMENTO_PIX_WRITE", "pagamento-pix.write");
define("SCOPE_PAGAMENTO_DARF_WRITE", "pagamento-darf.write");
define("SCOPE_PAGAMENTO_LOTE_READ", "pagamento-lote.read");
define("SCOPE_PAGAMENTO_LOTE_WRITE", "pagamento-lote.write pagamento-darf.write pagamento-boleto.write");
define("SCOPE_PIX_READ", "pix.read");
define("SCOPE_PIX_WRITE", "pix.write");
define("SCOPE_TED_WRITE", "ted.write");
define("SCOPE_WEBHOOK_READ", "webhook.read");
define("SCOPE_COB_READ", "cob.read");
define("SCOPE_COB_WRITE", "cob.write");
define("SCOPE_WEBHOOK_WRITE", "webhook.write");
define("SCOPE_PAYLOAD_LOCATION_WRITE", "payloadlocation.write");
define("SCOPE_PAYLOAD_LOCATION_READ", "payloadlocation.read");
define("SCOPE_WEBHOOK_BANKING_READ", "webhook-banking.read");
define("SCOPE_WEBHOOK_BANKING_WRITE", "webhook-banking.write");

define("BODY_URL_ENCODED", "application/x-www-form-urlencoded");


define("API_TYPE_BANKING", "BANKING");
define("API_TYPE_TOKEN", "TOKEN");
define("API_TYPE_PIX", "PIX");
define("API_TYPE_COBRANCA", "COBRANCA");
define("API_ENDPOINT_PATH_TOKEN", "authorize");
define("API_ENDPOINT_PATH_SALDO", "saldo");
define("API_ENDPOINT_PATH_EXTRATO_ENRIQUECIDO", "extratoEnriquecido");
define("API_ENDPOINT_PATH_EXTRATO_SIMPLES", "extratoSimples");
define("API_ENDPOINT_PATH_EXTRATO_PDF", "extratoPDF");
define("API_ENDPOINT_PATH_PAGAMENTOS", "pagamentos");
define("API_ENDPOINT_PATH_PAGAMENTOS_DARF", "pagamentosDarf");
define("API_ENDPOINT_PATH_PAGAMENTOS_LOTE", "pagamentosLote");
define("API_ENDPOINT_PATH_CONSULTAR_PIX", "consultarPix");
define("API_ENDPOINT_PATH_CONSULTAR_WEBHOOK","obterWebhook");
define("API_ENDPOINT_PATH_COBRANCAS_IMEDIATAS","listaCobrancaImediata");
define("API_ENDPOINT_PATH_COBRANCA_IMEDIATA", "cobrancaImediata");
define("API_ENDPOINT_PATH_LOCATIONS_CADASTRADAS","listaLocations");
define("API_ENDPOINT_PATH_GET_LOCATION","location");
define("API_ENDPOINT_PATH_GET_PIX","consultarPix");
define("API_ENDPOINT_PATH_GET_PIX_RECEBIDOS","pixRecebidos");
define("API_ENDPOINT_PATH_CONSULTAR_DEVOLUCAO_IMEDIATA","consultarDevolucaoImediata");
define("API_ENDPOINT_PATH_RECUPERAR_COLECAO_BOLETOS","colecaoBoleto");
define("API_ENDPOINT_PATH_RECUPERAR_SUMARIO_BOLETOS","sumarioBoleto");
define("API_ENDPOINT_PATH_RECUPERAR_BOLETO_DETALHADO","boletoDetalhado");
define("API_ENDPOINT_PATH_BOLETO_PDF", "boletoPDF");
define("API_ENDPOINT_PATH_EMITIR_BOLETO", "emitirBoleto");
define("API_ENDPOINT_PATH_CANCELAR_BOLETO", "cancelarBoleto");
define("API_ENDPOINT_PATH_DELETE_WEBHOOK", "deleteWebhook");
define("API_ENDPOINT_PATH_PUT_WEBHOOK", "criarWebhook");
define("API_ENDPOINT_PATH_INCLUI_PIX", "incluiPix");
define("API_ENDPOINT_PATH_INCLUI_TED", "incluiTed");
define("API_ENDPOINT_PATH_INCLUI_PAGAMENTO", "incluiPagamento");
define("API_ENDPOINT_PATH_INCLUI_PAGAMENTO_LOTE", "incluiLote");
define("API_ENDPOINT_PATH_INCLUI_PAGAMENTO_DARF", "incluiPagamentoDarf");
define("API_ENDPOINT_PATH_POST_COBRANCA_IMEDIATA", "criarCobrancaImediata");
define("API_ENDPOINT_PATH_PUT_COBRANCA_IMEDIATA", "criarCobrancaImediataTxId");
define("API_ENDPOINT_PATH_PATCH_COBRANCA_IMEDIATA", "revisarCobrancaImediata");
define("API_ENDPOINT_PATH_CRIAR_LOCATION", "criarLocation");
define("API_ENDPOINT_PATH_DESVINCULAR_LOCATION", "desvincularLocation");
define("API_ENDPOINT_PATH_SOLICITA_DEVOLUCAO", "solicitaDevolucao");


define("METHOD", "method");
define("ROUTE", "route");
define("VERIFY", "verify");
define("HEADERS", "headers");
define("AUTHORIZATION", "Authorization");
define("CONTENT_TYPE", "Content-Type");
define("INTER_SDK", "x-inter-sdk");
define("INTER_SDK_VERSION", "x-inter-sdk-version");
define("SDK", "php");
define("SDK_VERSION", "1.0.0");
define("FORM_PARAMS", "form_params");
define("CONTA_CORRENTE", "x-conta-corrente");
define("BEARER", "Bearer ");
define("CERT", "cert");
define("SSL_KEY", "ssl_key");
define("BODY", "body");
define("SCOPE", "scope");
define("GRANT_TYPE", "grant_type");
define("CLIENT_ID", "client_id");
define("CLIENT_SECRET", "client_secret");
define("CLIENT_CREDENTIALS", "client_credentials");

define("LOGS_INFO", "info");
define("LOGS_ERROR", "error");
define("LOGS_WARNING", "warning");
define("RAIZ", empty($_SERVER['DOCUMENT_ROOT']) ? __DIR__ . "/.." : $_SERVER['DOCUMENT_ROOT']);
define("LOGS_PATH", RAIZ . "/logs/");
define("LOGS_NAME", LOGS_PATH . 'inter-sdk-log-%s.txt');
define("LOGS_FORMAT", "[%s] [%s]: %s%s");

define("API", 'APIs');
define("URL", 'URL');
define("ENDPOINT", 'ENDPOINTS');

define("COMPLETE_DATE_FORMAT", 'd-m-Y H:i:s');
define("SIMPLE_DATE_FORMAT", 'd-m-Y');

define("LINE_BREAK", PHP_EOL);
define("TWO_POINTS", " : ");

define("DATA_INICIO_QUERY", "?dataInicio=");
define("DATA_FIM_QUERY", "&dataFim=");

define("DATA_INICIO_QUERY_COBRANCA", "?dataInicial=");
define("DATA_FIM_QUERY_COBRANCA", "&dataFinal=");

define("INICIO_QUERY", "?inicio=");
define("FIM_QUERY", "&fim=");

define("REQUEST_BODY", "Request Body: ");

define("PARAMETROS", "Parâmetros:");
define("ID", "Id: ");
define("END_TO_END_ID", "e2eId: ");
define("CHAVE", "Chave: ");
define("DATA", "Data: ");
define("TIPO_WEBHOOK", "Tipo Webhook: ");
define("LOTE", "Lote: ");
define("TXID", "Txid: ");
define("END_TO_END", "End To End: ");
define("DATA_INICIO", "Data de Início: ");
define("DATA_FIM", "Data de Fim: ");
define("BUSCA_PAGINADA", "Busca Paginada: ");
define("LOCATION_PRESENTE", "LocationPresente: ");
define("CPF", "CPF: ");
define("EMAIL", "EMAIL: ");
define("CNPJ", "CNPJ: ");
define("CPF_CNPJ", "CPF OU CNPJ: ");
define("NOME", "Nome: ");
define("STATUS", "Status: ");
define("ITENS_POR_PAGINA", "Itens por página: ");
define("PAGINA_ATUAL", "Página Atual: ");
define("TX_ID_PRESENTE", "TxIdPresente: ");
define("TIPO_COB", "Tipo Cob: ");
define("DEVOLUCAO_PRESENTE", "Devolução Presente: ");
define("TIPO_ORDENACAO", "Tipo de Ordenação: ");
define("ORDENAR_POR", "Ordenar Por: ");
define("NOSSO_NUMERO", "Nosso Numero: ");
define("SITUACAO", "Situação: ");

define("PAGINA", "Página: ");
define("TAMANHO_PAGINA", "Tamanho da Página: ");
define("TIPO_OPERACAO", "Tipo de Operação: ");
define("TIPO_TRANSACAO", "Tipo de Transação: ");
define("COD_BARRA_LINHA_DIGITAVEL", "Código de Barra Linha Digitável: ");
define("COD_TRANSACAO", "Código de Transação UUID: ");
define("FILTRA_DATA_POR", "Filtra data por: ");
define("COD_RECEITA", "Código de Receita: ");