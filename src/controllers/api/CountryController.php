<?php

namespace App\controllers\api;

use App\controllers\Controller;
use App\data\CountryApi;

class CountryController extends Controller
{
    public function getCountries()
    {
        $json = CountryApi::getCountries();
        $this->response(json_encode(json_decode($json)), true);
        return;
    }

    public function getCities()
    {
        $json = CountryApi::getCities();
        $this->response(json_encode(json_decode($json)), true);
        return;
    }
}
