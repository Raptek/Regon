<?php

namespace Raptek\Regon;

interface SearchResponseInterface
{
    public function getRegon();

    public function getName();

    public function getProvince();

    public function getDistrict();

    public function getCity();

    public function getPostalCode();

    public function getStreet();

    public function getType();
}