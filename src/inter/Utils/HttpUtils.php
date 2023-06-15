<?php

namespace Inter\Utils;

use Exception;
use Inter\Exception\ClientException;
use Inter\Exception\SdkException;
use Inter\Exception\ServerException;
use Inter\Model\Erro;

class HttpUtils
{

    private static $statusErro = "Status ERRO: ";

    public static function getConfigurations(): array
    {
        return [VERIFY => false];
    }

    public static function getOptions(string $token, string $cert_path, string $key_path, string $body = null, string $content_type = null, string $contaCorrente = null): array
    {
        if ($contaCorrente !== null) {

            $headers = [
                AUTHORIZATION => BEARER . $token,
                CONTA_CORRENTE => $contaCorrente,
                CONTENT_TYPE => $content_type,
                INTER_SDK => SDK,
                INTER_SDK_VERSION => SDK_VERSION
            ];

        } else {

            $headers = [
                AUTHORIZATION => BEARER . $token,
                CONTENT_TYPE => $content_type,
                INTER_SDK => SDK,
                INTER_SDK_VERSION => SDK_VERSION
            ];
        }
        return [

            HEADERS => $headers,
            CERT => $cert_path,
            SSL_KEY => $key_path,
            BODY => $body

        ];
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public static function trataRetorno(exception $exception, string $mensagem): void
    {
        LogUtils::logMsg(self::$statusErro . $exception->getResponse()->getStatusCode(), LOGS_ERROR);

        $response = $exception->getResponse();
        $originalException = $response->getBody()->getContents();
        $additionalMessage = $exception->getResponse()->getStatusCode() . "  " . $exception->getResponse()->getReasonPhrase();
        $erro = new Erro();

        if ($originalException !== null || $originalException !== "") {
            $data = json_decode($originalException, false, 512);
            $erro->set($data);
            $e = self::createException($exception->getResponse()->getStatusCode(), $mensagem . $exception->getMessage(), $erro);
        } else {
            $e = self::createException($exception->getResponse()->getStatusCode(), $mensagem . $additionalMessage, $erro);
        }

        self::lancaExcecao($e);

    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    private static function createException($statusCode, $message, $erro)
    {
        if ($statusCode >= 500) {
            return new ServerException($message, $erro);
        }

        if ($statusCode >= 400) {
            return new ClientException($message, $erro);
        }
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    private static function lancaExcecao(SdkException $e): void
    {
        LogUtils::logMsg(LogUtils::formataMsgException($e) . LINE_BREAK, LOGS_ERROR);
        throw $e;
    }


}