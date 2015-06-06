<?php

namespace Raptek\Regon;

use InvalidArgumentException;
use Raptek\Regon\Adapter\AdapterInterface;
use Raptek\Regon\Exception\InvalidCaptchaLengthException;
use Raptek\Regon\Exception\LoginException;
use Raptek\Regon\Validator\KrsValidator;
use Raptek\Regon\Validator\NipValidator;
use Raptek\Regon\Validator\RegonValidator;

class Client
{
    private $apiKey;
    private $adapter;

    public function __construct($apiKey, AdapterInterface $adapter)
    {
        $this->apiKey = $apiKey;
        $this->adapter = $adapter;
    }

    public function login()
    {
        $sid = $this->adapter->login($this->apiKey);

        if ($sid === RegonInterface::LOGIN_ERROR || strlen($sid) !== RegonInterface::SESSION_ID_LENGTH) {
            throw new LoginException();
        }

        return $sid;
    }

    public function logout($sid)
    {
        return $this->adapter->logout($sid);
    }

    public function getCaptcha($sid)
    {
        return $this->adapter->getCaptcha($sid);
    }

    public function checkCaptcha($sid, $captcha)
    {
        if (strlen($captcha) !== RegonInterface::CAPTCHA_LENGTH) {
            throw new InvalidCaptchaLengthException();
        }

        return $this->adapter->checkCaptcha($sid, $captcha);
    }

    public function searchByNip($sid, $value)
    {
        return $this->search($sid, RegonInterface::SEARCH_TYPE_NIP, $value);
    }

    public function search($sid, $type, $value)
    {
        $this->validate($type, $value);

        return $this->adapter->search($sid, $type, $value);
    }

    private function validate($type, $value)
    {
        $validator = $this->getValidator($type);

        return $validator->validate($value);
    }

    private function getValidator($type)
    {
        switch ($type) {
            case RegonInterface::SEARCH_TYPE_NIP:
                $validator = new NipValidator();
                break;
            case RegonInterface::SEARCH_TYPE_REGON:
                $validator = new RegonValidator();
                break;
            case RegonInterface::SEARCH_TYPE_KRS:
                $validator = new KrsValidator();
                break;
            default:
                throw new InvalidArgumentException();
                break;
        }

        return $validator;
    }

    public function searchByRegon($sid, $value)
    {
        return $this->search($sid, RegonInterface::SEARCH_TYPE_REGON, $value);
    }

    public function searchByKrs($sid, $value)
    {
        return $this->search($sid, RegonInterface::SEARCH_TYPE_KRS, $value);
    }
}
