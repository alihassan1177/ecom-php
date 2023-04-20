<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div style="background-color: transparent;" class="card  border-0 my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div style="border-radius: 5px;" class="col-lg-6 mx-auto bg-white shadow-lg">
                        <div class="p-lg-5 px-4 py-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <label for="#email" class="form-label pl-3">Email</label>    
                                <input type="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                <label for="#password" class="form-label pl-3">Password</label>    
                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password">
                                </div>
                                <button id="submit-btn" type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <hr>
                                <div id="alert" class="alert d-none" role="alert">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    const emailInp = document.querySelector("#email")
    const passwordInp = document.querySelector("#password")
    const submitBtn = document.querySelector("#submit-btn")
    const alert = document.querySelector("#alert")

    async function signIn() {
        alert.classList.add("d-none")
        const data = {
            email: emailInp.value,
            password: passwordInp.value
        }
        const response = await fetch("/admin/signin", {
            method: "POST",
            body: JSON.stringify(data)
        })
        
        const result = await response.json()
        alert.classList.remove("d-none")
        alert.innerText = result.message
        if (result.status == true) {
            alert.classList.add("alert-success")
            alert.classList.remove("alert-danger")
            window.location.href = "/admin"
        } else {
            alert.classList.add("alert-danger")
            alert.classList.remove("alert-success")
        }
    }

    submitBtn.addEventListener("click", (e) => {
        e.preventDefault()
        signIn()
    })
</script>