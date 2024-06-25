<?php

namespace Orders\Manager\Api;

use JsonException;
use Orders\Manager\Class\AbstractManager;
use Orders\Manager\Env\EnvManager;
use Orders\Manager\Requests\HttpMethodsType;

class APIManager extends AbstractManager
{

    public string $version = "v1";

    /**
     * @param \Orders\Manager\Requests\HttpMethodsType $methode
     * @param \Orders\Manager\Api\APITypes $type
     * @param string $slug
     * @param array $postFields
     * @return mixed
     */
    public function send(HttpMethodsType $methode, APITypes $type, string $slug, array $postFields = []): mixed
    {
        $url = match ($type) {
            APITypes::CUSTOMERS => EnvManager::getInstance()->getValue("API_URL_CUSTOMERS"),
            APITypes::ORDERS => EnvManager::getInstance()->getValue("API_URL_ORDERS"),
            APITypes::PRODUCTS => EnvManager::getInstance()->getValue("API_URL_PRODUCTS"),
            APITypes::MAILS => EnvManager::getInstance()->getValue("API_URL_MAILS"),
        };

        $headers = [
            'Authorization: ' . EnvManager::getInstance()->getValue('TOKEN'),
        ];


        $headers = array_merge($headers, [
            'User-Agent: order.payetonkawa.fr',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
        ]);

        $curl = curl_init();

        if ($methode === HttpMethodsType::PUT) {
            $postFields = json_encode($postFields);
        }


        curl_setopt_array($curl, [
            CURLOPT_URL => $url . $this->version . '/' . $slug,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => $methode->name,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_TCP_KEEPALIVE => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        if (empty($response)) {
            return [];
        }

        try {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            print $e;
            return false;
        }
    }
}