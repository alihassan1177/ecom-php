<?php

use App\data\CountryApi;
use App\controllers\api\CountryController;

$countryController = new CountryController();

$countries = CountryApi::getCountries();
$countries = json_decode($countries);

$id = isset($_SESSION["user"]) ? $_SESSION["user"]["id"] : "";
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
?>

<!-- Checkout Start -->
<div class="container-fluid pt-5">
  <div class="row px-xl-5">
    <div class="col-lg-8">
      <div class="mb-4">
        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
        <div id="checkout-form" class="row">
          <div class="col-md-12 form-group">
            <label>Name</label>
            <input id="name" class="form-control" type="text" placeholder="John Doe" value="<?= $name ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>E-mail</label>
            <input id="email" class="form-control" type="email" placeholder="example@email.com" value="<?= $email ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>Mobile No</label>
            <input id="phone" class="form-control" type="text" placeholder="+123 456 789" value="<?= $phone ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>Address</label>
            <input class="form-control" id="address" type="text" placeholder="123 Street" value="<?= $address->address ?>">
          </div>
          <div class="form-group col-md-6">
            <label>Country</label>
            <select id="select-country" class="custom-select">
              <option>--SELECT COUNTRY--</option>
              <?php

              foreach ($countries as $country) {
                $countryId = $country->id;
                $countryName = $country->name;
                if ($address->countryId == $countryId) {
                  echo "<option selected value='$countryId'>$countryName</option>";
                } else {
                  echo "<option value='$countryId'>$countryName</option>";
                }
              }

              ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>State</label>
            <select id="select-state" class="custom-select">
              <option value="">--SELECT STATE--</option>
              <?php

              if (count($states) > 0) {
                foreach ($states as $state) {
                  $stateId = $state->id;
                  $stateName = $state->name;
                  if ($address->stateId == $stateId) {
                    echo "<option selected value='$stateId'>$stateName</option>";
                  } else {
                    echo "<option value='$stateId'>$stateName</option>";
                  }
                }
              }

              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>City</label>
            <select id="select-city" class="custom-select">
              <option value="">--SELECT CITY--</option>
              <?php

              if (count($cities) > 0) {
                foreach ($cities as $city) {
                  $cityId = $city->id;
                  $cityName = $city->name;
                  if ($address->cityId == $cityId) {
                    echo "<option selected value='$cityId'>$cityName</option>";
                  } else {
                    echo "<option value='$cityId'>$cityName</option>";
                  }
                }
              }

              ?>

            </select>
          </div>


          <div class="col-md-6 form-group">
            <label>ZIP Code</label>
            <input id="zip" class="form-control" type="text" placeholder="123">
          </div>
          <?php if (!isset($_SESSION["client"])) : ?>
            <div class="col-md-12 form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="newaccount">
                <label class="custom-control-label" for="newaccount">Create an account</label>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>

    </div>
    <div class="col-lg-4">
      <div class="card border-secondary mb-5">
        <div class="card-header bg-secondary border-0">
          <h4 class="font-weight-semi-bold m-0">Order Total</h4>
        </div>
        <div class="card-body">
          <h5 class="font-weight-medium mb-3">Products</h5>
          <div id="checkout-products">
          </div>
          <hr class="mt-0">
          <div class="d-flex justify-content-between mb-3 pt-1">
            <h6 class="font-weight-medium">Subtotal</h6>
            <h6 id="cart-sub-total" class="font-weight-medium"></h6>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="font-weight-medium">Shipping</h6>
            <h6 class="font-weight-medium">$10</h6>
          </div>
        </div>
        <div class="card-footer border-secondary bg-transparent">
          <div class="d-flex justify-content-between mt-2">
            <h5 class="font-weight-bold">Total</h5>
            <h5 id="cart-total" class="font-weight-bold"></h5>
          </div>
        </div>
      </div>
      <div class="card border-secondary mb-5">
        <div class="card-header bg-secondary border-0">
          <h4 class="font-weight-semi-bold m-0">Payment</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <div class="custom-control custom-radio">
              <input type="radio" checked class="custom-control-input" value="1" name="payment" id="p">
              <label class="custom-control-label" for="p">Paypal</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" value="2" name="payment" id="dc">
              <label class="custom-control-label" for="dc">Direct Check</label>
            </div>
          </div>
          <div class="">
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" value="3" name="payment" id="bt">
              <label class="custom-control-label" for="bt">Bank Transfer</label>
            </div>
          </div>
        </div>
        <div class="card-footer border-secondary bg-transparent">
          <button id="order-btn" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Checkout End -->
<script>
  const CART_KEY_ALT = "cart"

  const checkoutProductsList = document.querySelector("#checkout-products")
  const selectedCart = JSON.parse(localStorage.getItem(CART_KEY_ALT)) || []

  setProductsListUI()

  function setProductsListUI() {
    if (selectedCart.length <= 0) {
      console.log("SELECTED CART IS EMPTY")
      return
    }

    let html = ""
    for (let i = 0; i < selectedCart.length; ++i) {
      html += productListItemUI(selectedCart[i])
    }
    checkoutProductsList.innerHTML = html
  }

  function productListItemUI({
    name,
    price,
    quantity
  }) {
    const html = `
 <div style="gap:10px" class="d-flex justify-content-between">
                        <p style="flex:1;">${name}</p>
                        <p><b>P</b>: $${price}</p>
                        <p><b>Q</b>: ${quantity}</p>
                    </div>
`
    return html
  }


  const selectCountry = document.querySelector("#select-country")
  const selectState = document.querySelector("#select-state")
  const selectCity = document.querySelector("#select-city")

  selectState.addEventListener("change", async (e) => {
    const countryId = selectCountry.value
    const stateId = e.target.value

    await getCitiesOfState(countryId, stateId)
  })

  async function getCitiesOfState(countryId, stateId) {
    const request = await fetch(`/cities?countryId=${countryId}&stateId=${stateId}`)
    const response = await request.json();
    const data = JSON.parse(response.message)

    let html = "<option>--SELECT CITY--</option>"
    if (data.length > 0) {
      data.forEach(city => {
        html += `<option value="${city.id}">${city.name}</option>`
      })
    } else {
      html += `<option value="0">Not on the List</option>`
    }

    selectCity.innerHTML = html
  }

  selectCountry.addEventListener("input", async (e) => {
    const countryId = e.target.value
    await getStatesOfCountry(countryId)
  })

  async function getStatesOfCountry(countryId) {
    const request = await fetch(`/states?countryId=${countryId}`)
    const response = await request.json();
    const data = JSON.parse(response.message)

    let html = "<option>--SELECT STATE--</option>"
    if (data.length > 0) {
      data.forEach(state => {
        html += `<option value="${state.id}">${state.name}</option>`
      })
    } else {
      html += `<option value="0">Not on the List</option>`
    }
    selectState.innerHTML = html

  }

  let conn = new WebSocket('ws://localhost:8080');

  conn.onopen = function() {
    console.log("Connection established!");
  }

  conn.onmessage = function(e) {
    console.log(e.data);
  };

  function sendOrderNotificationToAdmin() {
    conn.send("New Order Created")
  };

  const checkoutForm = document.querySelector("#checkout-form")
  const inputs = checkoutForm.querySelectorAll("input, select")
  const orderBtn = document.querySelector("#order-btn")

  const formData = new FormData()
  orderBtn.addEventListener("click", async () => {
    inputs.forEach(input => {
      if (input.type == "radio") {
        formData.append(input.name, input.value)
      } else {
        formData.append(input.id, input.value)
      }
    })

    formData.append("items", JSON.stringify(selectedCart))

    const request = await fetch("/order", {
      method: "POST",
      body: formData
    })

    const response = await request.json()
    console.log(response);

    sendOrderNotificationToAdmin()
  })
</script>