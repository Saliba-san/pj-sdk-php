<?php

namespace Inter;

use Exception;
use GuzzleHttp\Client;
use Inter\Exception\ClientException;
use Inter\Exception\ServerException;
use Inter\Utils\HttpUtils;
use Inter\Utils\LogUtils;
use Psr\Http\Message\ResponseInterface;

class CallAPI
{
    private $client;

    private static $statusSuccess = "Status Sucesso: ";
    private static $buscaTokenErrorMessage = "Erro ao obter token. ";
    private static $responseBody = "Response Body: ";

    private $debug;
    private $controleRateLimit;

    public function __construct(array $configurations, bool $debug = false, bool $controleRateLimit = true)
    {
        $this->client = new Client($configurations);
        $this->debug = $debug;
        $this->controleRateLimit = $controleRateLimit;
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    final public function buscaToken(string $method, string $url, array $options): ResponseInterface
    {
        try {

            if ($this->controleRateLimit) {
                $httpResponse = $this->trataChamadaModoRateLimit($method, $url, $options);
            } else {
                $httpResponse = $this->client->request($method, $url, $options);
            }

        } catch (exception $e) {
            HttpUtils::trataRetorno($e, self::$buscaTokenErrorMessage);
        }

        if ($this->debug) {
            LogUtils::logMsg(self::$responseBody . $httpResponse->getBody());
        }

        return $httpResponse;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @param string $message
     * @return ResponseInterface
     * @throws ClientException
     * @throws ServerException
     */
    final public function call(string $method, string $url, array $options, string $message): ResponseInterface
    {
        try {
            LogUtils::logMsg(URL . TWO_POINTS . $url);

            if ($this->controleRateLimit) {
                $httpResponse = $this->trataChamadaModoRateLimit($method, $url, $options);
            } else {
                $httpResponse = $this->client->request($method, $url, $options);
            }

        } catch (exception $e) {
            HttpUtils::trataRetorno($e, $message);
        }

        LogUtils::logMsg(self::$statusSuccess . $httpResponse->getStatusCode() . LINE_BREAK);

        if ($this->debug) {
            LogUtils::logMsg(self::$responseBody . $httpResponse->getBody());
        }

        return $httpResponse;
    }

    final public function trataChamadaModoRateLimit(string $method, string $url, array $options): ResponseInterface
    {
        while (true) {
            try {
                return $this->client->request($method, $url, $options);
            } catch (exception $e) {

                if ($e->getResponse()->getStatusCode() !== 429) {
                    throw $e;
                }

                LogUtils::logMsg(LogUtils::formata429($url . LINE_BREAK), LOGS_WARNING);
                sleep(60);
            }
        }
    }
}