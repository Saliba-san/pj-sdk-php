<?php

namespace Inter\Utils;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Inter\CallAPI;
use Inter\Exception\ClientException;
use Inter\Exception\SdkException;
use Inter\Exception\ServerException;

class TokenUtils
{
    private static $TEMPO_FOLGA = 60;
    private static $tokens = [];

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public static function buscaToken(string $clientSecret, string $clientId, string $scope, string $certificado,
                                      string $senha, string $ambiente = "hml", string $contaCorrente = null,
                                      bool   $debug = false, bool $controleRateLimit = true): string
    {
        $respostaObterToken = self::recuperaToken($clientId, $clientSecret, $scope);
        $tokenValido = self::validar($respostaObterToken);

        if (!$tokenValido) {
            $respostaObterToken = self::call($clientSecret, $clientId, $scope, $certificado, $senha, $ambiente, $contaCorrente, $debug, $controleRateLimit);
            self::adicionarAoMapa($clientId, $clientSecret, $scope, $respostaObterToken);
        }

        return $respostaObterToken->access_token;
    }

    private static function recuperaToken(string $clientId, string $clientSecret, string $scope)
    {
        $key = $clientId . TWO_POINTS . $clientSecret . TWO_POINTS . $scope;

        return self::$tokens[$key] ?? null;
    }

    private static function validar(object $respostaObterToken = null): bool
    {
        if ($respostaObterToken == null) {
            return false;
        }

        $dataExpiracao = $respostaObterToken->expires_in;
        $createdDate = $respostaObterToken->createdDate;
        $agora = new DateTime();

        $diff = date_diff($agora, $createdDate);

        return ($diff->s + self::$TEMPO_FOLGA) <= $dataExpiracao;
    }


    /**
     * @param string $clientSecret
     * @param string $clientId
     * @param string $scope
     * @param string $certificado
     * @param string $senha
     * @param string $ambiente
     * @param string|null $contaCorrente
     * @param bool $debug
     * @param bool $controleRateLimit
     * @return mixed
     * @throws ClientException
     * @throws GuzzleException
     * @throws SdkException
     */
    private static function call(string $clientSecret, string $clientId, string $scope, string $certificado,
                                 string $senha, string $ambiente = 'hml', string $contaCorrente = null,
                                 bool   $debug = false, bool $controleRateLimit = true): object
    {

        $configurations = [
            VERIFY => false
        ];

        if ($contaCorrente !== null) {

            $headers = [
                CONTENT_TYPE => BODY_URL_ENCODED,
                CONTA_CORRENTE => $contaCorrente,
                INTER_SDK => SDK,
                INTER_SDK_VERSION => SDK_VERSION
            ];

        } else {

            $headers = [
                CONTENT_TYPE => BODY_URL_ENCODED,
                INTER_SDK => SDK,
                INTER_SDK_VERSION => SDK_VERSION
            ];
        }

        $options = [

            HEADERS => $headers,

            FORM_PARAMS => [
                CLIENT_ID => $clientId,
                CLIENT_SECRET => $clientSecret,
                GRANT_TYPE => CLIENT_CREDENTIALS,
                SCOPE => $scope
            ],

            CERT => $certificado,
            SSL_KEY => $senha

        ];

        $baseUrl = ConfigUtils::getBaseUrl($ambiente, API_TYPE_TOKEN);
        $path = ConfigUtils::getPath(API_TYPE_TOKEN, API_ENDPOINT_PATH_TOKEN);

        $METHOD = $path[METHOD];
        $URL = $baseUrl . $path[ROUTE];

        $callApi = new CallAPI($configurations, $debug, $controleRateLimit);
        $http_response = $callApi->buscaToken($METHOD, $URL, $options);
        $response = json_decode($http_response->getBody(), false);
        $response->createdDate = new DateTime();

        return $response;
    }

    private static function adicionarAoMapa(string $clientId, string $clientSecret, string $scope,
                                            object $respostaObterToken): void
    {
        $key = $clientId . TWO_POINTS . $clientSecret . TWO_POINTS . $scope;
        self::$tokens[$key] = $respostaObterToken;
    }

}