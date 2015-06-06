<?php

namespace Raptek\Regon\Validator;

use InvalidArgumentException;
use Raptek\Regon\Exception\InvalidArgumentLengthException;

class NipValidator implements ValidatorInterface
{
    public function validate($value)
    {
        if (null === $value || '' === $value || !is_scalar($value)) {
            throw new InvalidArgumentException();
        }

        $stringValue = (string) $value;
        $nip = preg_replace('/[ -]/im', '', $stringValue);
        $length = strlen($nip);

        if ($length !== 10) {
            throw new InvalidArgumentLengthException();
        }

        $mod = 11;
        $sum = 0;
        $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
        $digits = [];
        preg_match_all("/\d/", $nip, $digits);
        $digitsArray = $digits[0];

        foreach ($digitsArray as $digit) {
            $weight = current($weights);
            $sum += $digit * $weight;
            next($weights);
        }

        if ((($sum % $mod == 10) ? 0 : $sum % $mod) != $digitsArray[$length - 1]) {
            throw new InvalidArgumentException('Podany numer NIP jest niepoprawny');
        }

        return true;
    }
}
