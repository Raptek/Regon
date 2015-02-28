<?php

namespace Raptek\Regon;

class Regon
{
    const SERVICE_URL = 'https://wyszukiwarkaregon.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc';
    const SERVICE_URL_TEST = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc';

    const SESSION_ID = 'sid';
    const SESSION_ID_LENGTH = 20;

    const LOGIN_ERROR = -1;

    const CAPTCHA_LENGTH = 5;

    const PARAM_API_KEY = 'pKluczUzytkownika';
    const PARAM_CAPTCHA = 'pCaptcha';
    const PARAM_SESSION_ID = 'pIdentyfikatorSesji';
    const PARAM_REGON = 'pRegon';
    const PARAM_REPORT_NAME = 'pNazwaRaportu';
    const PARAM_SEARCH_PARAMS = 'pParametryWyszukiwania';

    const SEARCH_TYPE_KRS = 'Krs';
    const SEARCH_TYPE_KRSY = 'Krsy';
    const SEARCH_TYPE_NIP = 'Nip';
    const SEARCH_TYPE_NIPY = 'Nipy';
    const SEARCH_TYPE_REGON = 'Regon';
    const SEARCH_TYPE_REGONY9 = 'Regony9zn';
    const SEARCH_TYPE_REGONY14 = 'Regony14zn';
}