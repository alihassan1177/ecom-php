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
    $countryId =  $_GET["countryId"];
    $stateId = $_GET["stateId"];
    $json = CountryApi::getCities();
    $data = json_decode($json);

    if (empty(intval($countryId)) && empty(intval($stateId))) {
      $this->response(json_encode($data), false);
      return;
    }

    $cities = [];
    foreach ($data as $city) {
      if ($city->countryId == $countryId && $city->stateId == $stateId) {
        $cities[] = $city;
      }
    }

    $this->response(json_encode($cities), true);
    return;
  }

  public function getCitiesByParams($countryId = null, $stateId = null)
  {
    $countryId = $countryId != null ? $countryId : $_GET["countryId"];
    $stateId = $stateId != null ? $stateId : $_GET["stateId"];
    $json = CountryApi::getCities();
    $data = json_decode($json);

    if (empty(intval($countryId)) && empty(intval($stateId))) {
      $this->response(json_encode($data), false);
      return;
    }

    $cities = [];
    foreach ($data as $city) {
      if ($city->countryId == $countryId && $city->stateId == $stateId) {
        $cities[] = $city;
      }
    }

    return $cities;
  }


  public function getStatesByParams($countryId = null)
  {
    $countryId = $countryId != null ? $countryId : $_GET["countryId"];
    $json = CountryApi::getStates();
    $data = json_decode($json);

    if (empty(intval($countryId))) {
      $this->response(json_encode($data), false);
      return;
    }

    $states = [];
    foreach ($data as $state) {
      if ($state->countryId == $countryId) {
        $states[] = $state;
      }
    }

    return $states;
  }

  public function getStates()
  {
    $countryId = $_GET["countryId"];
    $json = CountryApi::getStates();
    $data = json_decode($json);

    if (empty(intval($countryId))) {
      $this->response(json_encode($data), false);
      return;
    }

    $states = [];
    foreach ($data as $state) {
      if ($state->countryId == $countryId) {
        $states[] = $state;
      }
    }

    $this->response(json_encode($states), true);
    return;
  }
}
