<?php

namespace Raptek\Regon\Validator;

use InvalidArgumentException;
use Raptek\Regon\Exception\InvalidArgumentLengthException;

class KrsValidator implements ValidatorInterface
{
    public function validate($value)
    {
        if (null === $value || '' === $value || !is_scalar($value)) {
            throw new InvalidArgumentException();
        }

        $stringValue = (string)$value;
        $krs = preg_replace('/[ -]/im', '', $stringValue);
        $length = strlen($krs);

        if ($length !== 11) {
            throw new InvalidArgumentLengthException();
        }

        // TODO Ogarnąć walidację numeru KRS

        return true;
    }
}