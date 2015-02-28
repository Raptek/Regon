<?php

namespace Raptek\Regon;

use Raptek\Regon\Adapter\AdapterInterface;
use Raptek\Regon\Exception\InvalidCaptchaLengthException;
use Raptek\Regon\Exception\LoginException;

class Client
{
    private $apiKey;
    private $adapter;
    private $sid;

    public function __construct($apiKey, AdapterInterface $adapter)
    {
        $this->apiKey = $apiKey;
        $this->adapter = $adapter;
    }

    public function login()
    {
        $sid = $this->adapter->login($this->apiKey);

        if ($sid === Regon::LOGIN_ERROR || strlen($sid) !== Regon::SESSION_ID_LENGTH) {
            throw new LoginException();
        }

        $this->sid = $sid;
    }

    public function logout()
    {
        return $this->adapter->logout($this->sid);
    }

    public function getCaptcha()
    {
        return $this->adapter->getCaptcha($this->sid);
    }

    public function checkCaptcha($captcha)
    {
        if (strlen($captcha) !== Regon::CAPTCHA_LENGTH) {
            throw new InvalidCaptchaLengthException();
        }

        return $this->adapter->checkCaptcha($this->sid, $captcha);
    }

    public function search($type, $values)
    {
        return $this->adapter->search($this->sid, $type, $values);
    }

    public function searchByNip($value)
    {
        return $this->search(Regon::SEARCH_TYPE_NIP, $value);
    }

    public function searchByRegon($value)
    {
        return $this->search(Regon::SEARCH_TYPE_REGON, $value);
    }

    public function searchByKrs($value)
    {
        return $this->search(Regon::SEARCH_TYPE_KRS, $value);
    }

    private function validate($type, $value)
    {

    }
}