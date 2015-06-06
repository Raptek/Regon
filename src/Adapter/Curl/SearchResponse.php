<?php

namespace Raptek\Regon\Adapter\Curl;

use Raptek\Regon\SearchResponseInterface;
use SimpleXMLElement;

class SearchResponse implements SearchResponseInterface
{
    private $regon;
    private $name;
    private $province;
    private $district;
    private $commune;
    private $city;
    private $postalCode;
    private $street;
    private $type;

    public function __construct(SimpleXMLElement $response)
    {
        $this->regon = $response->Regon->__toString();
        $this->name = $response->Nazwa->__toString();
        $this->province = $response->Wojewodztwo->__toString();
        $this->district = $response->Powiat->__toString();
        $this->commune = $response->Gmina->__toString();
        $this->city = $response->Miejscowosc->__toString();
        $this->postalCode = $response->KodPocztowy->__toString();
        $this->street = $response->Ulica->__toString();
        $this->type = $response->Typ->__toString();
    }

    public function getRegon()
    {
        return $this->regon;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getCommune()
    {
        return $this->commune;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getType()
    {
        return $this->type;
    }
}
