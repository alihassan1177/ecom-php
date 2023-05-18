<?php

$name = isset($_SESSION["user"]) ? $_SESSION["user"]["name"] : "";
$email = isset($_SESSION["user"]) ? $_SESSION["user"]["email"] : "";
$address = isset($_SESSION["user"]) ? $_SESSION["user"]["address"] : "";
$phone = isset($_SESSION["user"]) ? $_SESSION["user"]["phone"] : "";

?>

<!-- Checkout Start -->
<div class="container-fluid pt-5">
  <div class="row px-xl-5">
    <div class="col-lg-8">
      <div class="mb-4">
        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
        <div class="row">
          <div class="col-md-12 form-group">
            <label>Name</label>
            <input class="form-control" type="text" placeholder="John Doe" value="<?= $name ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>E-mail</label>
            <input class="form-control" type="text" placeholder="example@email.com" value="<?= $email ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>Mobile No</label>
            <input class="form-control" type="text" placeholder="+123 456 789" value="<?= $phone ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>Address Line 1</label>
            <input class="form-control" type="text" placeholder="123 Street" value="<?= $address ?>">
          </div>
          <div class="col-md-6 form-group">
            <label>Country</label>
            <select class="custom-select">
              <option selected>United States</option>
              <option>Afghanistan</option>
              <option>Albania</option>
              <option>Algeria</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>City</label>
            <input class="form-control" type="text" placeholder="New York">
          </div>
          <div class="col-md-6 form-group">
            <label>State</label>
            <input class="form-control" type="text" placeholder="New York">
          </div>
          <div class="col-md-6 form-group">
            <label>ZIP Code</label>
            <input class="form-control" type="text" placeholder="123">
          </div>
          <div class="col-md-12 form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="newaccount">
              <label class="custom-control-label" for="newaccount">Create an account</label>
            </div>
          </div>

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
              <input type="radio" class="custom-control-input" name="payment" id="paypal">
              <label class="custom-control-label" for="paypal">Paypal</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="payment" id="directcheck">
              <label class="custom-control-label" for="directcheck">Direct Check</label>
            </div>
          </div>
          <div class="">
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
              <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
            </div>
          </div>
        </div>
        <div class="card-footer border-secondary bg-transparent">
          <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
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
</script>