<?php

namespace Raptek\Regon\Adapter\Curl;

use Curl\Curl;
use Raptek\Regon\Adapter\AdapterInterface;
use Raptek\Regon\Adapter\Curl\Exception\CurlException;
use Raptek\Regon\Regon;

class CurlAdapter implements AdapterInterface
{
    const URL_LOGIN = 'Zaloguj';
    const URL_LOGOUT = 'Wyloguj';
    const URL_CAPTCHA_GET = 'PobierzCaptcha';
    const URL_CAPTCHA_CHECK = 'SprawdzCaptcha';
    const URL_SEARCH = 'daneSzukaj';
    const URL_GET_REPORT = 'DanePobierzPelnyRaport';

    private $endpoint = '/ajaxEndpoint/';
    private $curl;

    public function __construct()
    {
        $this->curl = new Curl();
        $this->curl->setHeader('Content-Type', 'application/json');
        // TODO Ogarnąć certyfikat
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function login($apiKey)
    {
        $data = [
            Regon::PARAM_API_KEY => $apiKey
        ];
        $this->curl->post($this->getUrl(self::URL_LOGIN), $this->prepareData($data));

        return $this->getResponse();
    }

    public function logout($sid)
    {
        $data = [
            Regon::PARAM_SESSION_ID => $sid
        ];
        $this->curl->post($this->getUrl(self::URL_LOGOUT), $this->prepareData($data));

        return $this->getResponse();
    }

    public function getCaptcha($sid)
    {
        $this->curl->setHeader(Regon::SESSION_ID, $sid);
        $this->curl->post($this->getUrl(self::URL_CAPTCHA_GET), $this->prepareData([]));

        return $this->getResponse();
    }

    public function checkCaptcha($sid, $captcha)
    {
        $data = [
            Regon::PARAM_CAPTCHA => $captcha
        ];
        $this->curl->setHeader(Regon::SESSION_ID, $sid);
        $this->curl->post($this->getUrl(self::URL_CAPTCHA_CHECK), $this->prepareData($data));

        return $this->getResponse();
    }

    public function search($sid, $type, $values)
    {
        $data = [
            Regon::PARAM_SEARCH_PARAMS => [
                $type => $values
            ]
        ];
        $this->curl->setHeader(Regon::SESSION_ID, $sid);
        $this->curl->post($this->getUrl(self::URL_SEARCH), $this->prepareData($data));

        return new SearchResponse(simplexml_load_string($this->getResponse())->dane);
    }

    private function getResponse()
    {
        if ($this->curl->error) {
            throw new CurlException($this->curl->error_message, $this->curl->error_code);
        }

        return $this->curl->response->d;
    }

    private function getUrl($action)
    {
        return sprintf('%s%s%s', Regon::SERVICE_URL_TEST, $this->endpoint, $action);
    }

    private function prepareData(array $data)
    {
        return json_encode($data);
    }
}