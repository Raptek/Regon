<?php

namespace Raptek\Regon\Adapter;

interface AdapterInterface
{
    public function login($apiKey);

    public function logout($sid);

    public function getCaptcha($sid);

    public function checkCaptcha($sid, $captcha);

    public function search($sid, $type, $values);
}
