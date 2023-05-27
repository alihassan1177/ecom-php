<?php

use App\data\CountryApi;
use App\controllers\api\CountryController;

$countryController = new CountryController();

$countries = CountryApi::getCountries();
$countries = json_decode($countries);

$name = isset($_SESSION["user"]) ? $_SESSION["user"]["name"] : "";
$email = isset($_SESSION["user"]) ? $_SESSION["user"]["email"] : "";
$address = isset($_SESSION["user"]) ? $_SESSION["user"]["address"] : "";
$phone = isset($_SESSION["user"]) ? $_SESSION["user"]["phone"] : "";
$address = json_decode($address);

$states = [];
$cities = [];

if ($address != null) {
  $states = $countryController->getStatesByParams($address->countryId);
  $cities = $countryController->getCitiesByParams($address->countryId, $address->stateId);
}

$addressString = $address->address;

foreach ($cities as $city) {
  if ($city->id == $address->cityId) {
    $addressString .= ", $city->name";
  }
}

foreach ($states as $state) {
  if ($state->id == $address->stateId) {
    $addressString .= ", $state->name";
  }
}

foreach ($countries as $country) {
  if ($country->id == $address->countryId) {
    $addressString .= ", $country->name";
  }
}

?>

<div class="container">
  <div class="row">
    <div class="col-md-8 py-4">

      <h2 class="mb-3">Order History</h2>
      <p>No Order History available</p>

    </div>

    <div class="border-left col-md-4 py-4">
      <h2 class="mb-3">Account Details</h2>
      <p class="m-0 text-dark">Name</p>
      <p><?= $name ?></p>
      <hr>
      <p class="m-0 text-dark">Phone</p>
      <p><?= $phone ?></p>
      <hr>
      <p class="m-0 text-dark">Email</p>
      <p><?= $email ?></p>
      <hr>
      <p class="m-0 text-dark">Address</p>
      <p><?= $addressString ?></p>
      <hr>
      <p class="mb-1 text-dark">Actions</p>
      <a href="/logout" class="btn btn-sm rounded btn-danger">Logout</a>
      <a href="/edit" class="btn btn-sm rounded btn-warning">Edit</a>
    </div>
  </div>
</div>
