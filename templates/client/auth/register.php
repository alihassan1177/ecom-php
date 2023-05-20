<?php

use App\data\CountryApi;

$countries = CountryApi::getCountries();
$countries = json_decode($countries);

?>


<!-- Contact Start -->
<div class="container-fluid pt-5">
  <div class="text-center mb-3">
    <h2 class="section-title px-5"><span class="px-2">Create new Account</span></h2>
  </div>
  <div class="row px-xl-5">
    <div class="col-lg-6 mx-auto mb-5">
      <div class="contact-form">
        <div id="success" class="d-none alert alert-success"></div>
        <div id="error-holder" class="d-none alert alert-danger" role="alert">
          <ul id="error-list">
          </ul>
        </div>
        <form id="register-form" class="row" novalidate="novalidate">
          <div class="control-group col-12">
            <label>Name</label>
            <input type="text" class="form-control" id="name" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group col-12">
            <label>Email</label>
            <input type="email" class="form-control" id="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group col-12">
            <label>Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" required="required" data-validation-required-message="Please enter a password" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="form-group col-md-6">
            <label>Country</label>
            <select id="select-country" class="custom-select">
              <option selected>--SELECT COUNTRY--</option>
              <?php

              foreach ($countries as $country) {
                $countryId = $country->id;
                $countryName = $country->name;
                echo "<option value='$countryId'>$countryName</option>";
              }

              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>State</label>
            <select id="select-state" class="custom-select">
              <option value="">--SELECT STATE--</option>
            </select>
          </div>
          <div class="form-group col-12">
            <label>City</label>
            <select id="select-city" class="custom-select">
              <option value="">--SELECT CITY--</option>
            </select>
          </div>

          <div class="control-group col-12">
            <label>Address</label>
            <input type="text" class="form-control" id="address" placeholder="Address" required="required" data-validation-required-message="Please enter a Address" />
            <p class="help-block text-danger"></p>
          </div>

          <div class="control-group col-12">
            <label>Phone Number</label>
            <input type="text" class="form-control" id="phone" placeholder="Phone No" required="required" data-validation-required-message="Please enter a Phone Number" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="col-12">
            <button class="btn btn-primary py-2 px-4" type="submit" id="submit-btn">Register</button>
          </div>
        </form>
        <p class="mt-3">Already have an Account? <a href="/login">Login Here</a></p>

      </div>
    </div>

  </div>
</div>
<!-- Contact End -->


<script type="module">
  const registerForm = document.querySelector("#register-form")
  const inputs = registerForm.querySelectorAll("input, select, button")

  const errorHolder = document.querySelector("#error-holder")
  const errorList = document.querySelector("#error-list")
  const successHolder = document.querySelector("#success")

  const totalInputs = inputs.length

  const selectCountry = document.querySelector("#select-country")
  const selectState = document.querySelector("#select-state")
  const selectCity = document.querySelector("#select-city")

  for (let i = 0; i < totalInputs; i++) {
    const element = inputs[i];
    if (inputs[i + 1] != undefined) {
      inputs[i + 1].disabled = true
    }
    if (element.tagName == "SELECT" || element.tagName == "INPUT") {
      element.addEventListener("input", (e) => {
        if (e.target.value != "") {
          inputs[i + 1].disabled = false
        } else {
          inputs[i + 1].disabled = true
        }
      })
    }
  }

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

  async function sendRequest() {
    errorHolder.classList.add("d-none")
    successHolder.classList.add("d-none")

    const formData = new FormData()
    inputs.forEach(input => {
      formData.append(input.id, input.value)
    })

    const request = await fetch("/user/register", {
      method: "POST",
      body: formData
    })

    const response = await request.json()
    if (response.status == true) {
      successHolder.innerHTML = response.message
      successHolder.classList.remove("d-none")

       //window.location.href = "/login"

    } else {
      const errors = JSON.parse(response.message)
      let html = ""
      Object.keys(errors).forEach(key => {
        const errorListItem = `<li>${key.toLocaleUpperCase()} ${errors[key]}</li>`
        html += errorListItem
      })
      errorList.innerHTML = html
      errorHolder.classList.remove("d-none")
    }
  }

  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault()
    await sendRequest()
  })
</script>



<!-- Contact End -->
