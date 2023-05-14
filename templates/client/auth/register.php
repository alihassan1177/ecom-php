<!-- Contact Start -->
<div class="container-fluid pt-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5"><span class="px-2">Create new Account</span></h2>
  </div>
  <div class="row px-xl-5">
    <div class="col-lg-6 mx-auto mb-5">
      <div class="contact-form">
        <div id="success"></div>
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

  async function sendRequest() {
    const formData = new FormData()
    inputs.forEach(input => {
      formData.append(input.id, input.value)
    })
    const request = await fetch("/user/register", {
      method: "POST",
      body : formData
    })
    const response = await request.json()
    console.log(response)
  }

  registerForm.addEventListener("submit", async(e) => {
    e.preventDefault()
    await sendRequest()
  })
</script>



<!-- Contact End -->
