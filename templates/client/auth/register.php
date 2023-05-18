<!-- Contact Start -->
<div class="container-fluid pt-5">
  <div class="text-center mb-4">
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
        <form id="register-form" novalidate="novalidate">
          <div class="control-group">
            <input type="text" class="form-control" id="name" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <input type="email" class="form-control" id="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <input type="password" class="form-control" id="password" placeholder="Password" required="required" data-validation-required-message="Please enter a password" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <input type="text" class="form-control" id="address" placeholder="Address" required="required" data-validation-required-message="Please enter a Address" />
            <p class="help-block text-danger"></p>
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
          <div class="control-group">
            <input type="text" class="form-control" id="phone" placeholder="Phone No" required="required" data-validation-required-message="Please enter a Phone Number" />
            <p class="help-block text-danger"></p>
          </div>
          <div>
            <button class="btn btn-primary py-2 px-4" type="submit" id="submit-btn">Register</button>
          </div>
        </form>
        <p class="mt-3">Already have an Account? <a href="/login">Login Here</a></p>

      </div>
    </div>

  </div>
</div>
<!-- Contact End -->


<script>
  const registerForm = document.querySelector("#register-form")
  const inputs = registerForm.querySelectorAll("input")

  const errorHolder = document.querySelector("#error-holder")
  const errorList = document.querySelector("#error-list")
  const successHolder = document.querySelector("#success")

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

      window.location.href = "/login"

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