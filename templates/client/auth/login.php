<!-- Login Start -->
<div class="container-fluid pt-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5"><span class="px-2">Login to Dashboard</span></h2>
  </div>
  <div class="row px-xl-5">
    <div class="col-lg-6 mx-auto mb-5">

      <div class="contact-form">
        <div id="success" class="d-none alert alert-success"></div>
        <div id="error-holder" class="d-none alert alert-danger" role="alert">
          <ul id="error-list">
          </ul>
        </div>
        <form id="login-form">
          <div class="control-group">
            <input type="email" class="form-control" id="email" placeholder="Email" data-validation-required-message="Please enter your email" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <input type="password" class="form-control" id="password" placeholder="Password" required="required" data-validation-required-message="Please enter a subject" />
            <p class="help-block text-danger"></p>
          </div>
          <div>
            <button id="submit-btn" class="btn btn-primary py-2 px-4" type="submit">Login</button>
          </div>
        </form>
        <p class="mt-3">Don't have an Account? <a href="/register">Signup for free</a></p>
      </div>
    </div>

  </div>
</div>
<!-- Login End -->

<script>
  const form = document.querySelector("#login-form")
  const emailInput = document.querySelector("#email")
  const passwordInput = document.querySelector("#password")
  const submitBtn = document.querySelector("#submit-btn")

  const errorHolder = document.querySelector("#error-holder")
  const errorList = document.querySelector("#error-list")
  const successHolder = document.querySelector("#success")


  async function sendRequest() {
    const formData = new FormData()
    formData.append("email", emailInput.value)
    formData.append("password", passwordInput.value)

    const request = await fetch("/user/login", {
      method: "POST",
      body: formData
    })

    const response = await request.json()
    if (response.status == true) {
      successHolder.innerHTML = response.message
      successHolder.classList.remove("d-none")

      window.location.href = "/dashboard"

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

  form.addEventListener("submit", async (e) => {
    e.preventDefault()
    await sendRequest()
  })
</script>