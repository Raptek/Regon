<?php

namespace Raptek\Regon\Validator;

use InvalidArgumentException;
use Raptek\Regon\Exception\InvalidArgumentLengthException;

class RegonValidator implements ValidatorInterface
{
    public function validate($value)
    {
        if (null === $value || '' === $value || !is_scalar($value)) {
            throw new InvalidArgumentException();
        }

        $stringValue = (string) $value;
        $regon = preg_replace('/[ -]/im', '', $stringValue);
        $length = strlen($regon);

        if ($length !== 9 && $length !== 14) {
            throw new InvalidArgumentLengthException();
        }

        $mod = 11;
        $sum = 0;
        $weights[9] = [8, 9, 2, 3, 4, 5, 6, 7];
        $weights[14] = [2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8];
        $digits = [];
        preg_match_all("/\d/", $regon, $digits);
        $digitsArray = $digits[0];
        $weights = $weights[$length];

        foreach ($digitsArray as $digit) {
            $weight = current($weights);
            $sum += $digit * $weight;
            next($weights);
        }

        if ((($sum % $mod == 10) ? 0 : $sum % $mod) != $digitsArray[$length - 1]) {
            throw new InvalidArgumentException('Podany numer REGON jest niepoprawny');
        }

        return true;
    }
}
