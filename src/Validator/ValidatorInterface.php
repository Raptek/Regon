<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof
 * Date: 2015-02-28
 * Time: 19:16
 */
namespace Raptek\Regon\Validator;

interface ValidatorInterface
{
    public function validate($value);
}