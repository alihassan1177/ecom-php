const CART_KEY = "cart"


const EventListeners = {
  "increment-btn": (id) => increaseQuantity(id),
  "decrement-btn": (id) => decreaseQuantity(id),
  "remove-btn": (id) => removeItemFromCart(id)
}

const items = []

const addToCartBtns = document.querySelectorAll("#add-to-cart")

addToCartBtns.forEach(btn => {
  const id = btn.dataset.id
  btn.addEventListener("click", (e) => {
    e.preventDefault()
    const product = findProductInProductsData(id)
    if (product !== false) {
      addProductInCart(product)
    }
  })
})

let cartTotal = 0

const cart = JSON.parse(localStorage.getItem(CART_KEY)) || items
const cartCountElement = document.querySelector("#cart-item-count")
const cartTotalElement = document.querySelector("#cart-total")
const cartSubTotalElement = document.querySelector("#cart-sub-total")
setCartTotal()


updateCartCount()

const cartBody = document.querySelector("#cart-body")
updateCartUI()

function setCartTotal() {
  if (cartTotalElement === null || cartSubTotalElement === null) {
    console.log("CART TOTAL ELEMENT IS NULL")
    return
  }
  if (cart.length < 0) {
    console.log("NO ITEMS IN CART")
    return
  }

  let total = 0
  for (let i = 0; i < cart.length; ++i) {
    const cartItem = cart[i]
    total += (cartItem.quantity * cartItem.price)
  }
  cartTotalElement.innerHTML = `$${total + 10}`
  cartSubTotalElement.innerHTML = `$${total}`
}

function attachListener(btn) {
  const id = btn.dataset.id
  btn.addEventListener("click", () => EventListeners[btn.id](id))
}

function findProductInProductsData(id) {
  if (productsData.length > 0) {
    for (let i = 0; i < productsData.length; ++i) {
      if (productsData[i].id == id) {
        return productsData[i]
      }
    }
  }

  return false

}

function setListeners() {
  const incrementBtns = document.querySelectorAll("#increment-btn")
  const decrementBtns = document.querySelectorAll("#decrement-btn")
  const removeBtns = document.querySelectorAll("#remove-btn")

  incrementBtns.forEach(btn => attachListener(btn))
  decrementBtns.forEach(btn => attachListener(btn))
  removeBtns.forEach(btn => attachListener(btn))
}

function updateCartCount() {
  cartCountElement.innerHTML = cart.length
}

function increaseQuantity(id) {
  const item = findItemInCart(id)
  item.quantity += 1
  updateCartUI()
  saveCart()
}

function decreaseQuantity(id) {
  const item = findItemInCart(id)
  if (item.quantity == 0) {
    return;
  }
  item.quantity -= 1
  updateCartUI()
  saveCart()
}

async function saveCartToServer(){
  const formData = new FormData()

  formData.append("cart", JSON.stringify(cart))
  formData.append("checkout", "false")

  const request = await fetch("/saveCart", {
    method : "POST",
    body : formData 
  })
  const response = await request.json()

  console.log(response)
}

function removeItemFromCart(id) {
  let index;
  for (let i = 0; i < cart.length; ++i) {
    if (cart[i].id == id) {
      index = i
      break;
    }
  }

  cart.splice(index, 1)
  updateCartUI()
  updateCartCount()
  saveCart()
}

function createCartItemUI({ id, name, quantity, price, image }) {
  const html = `
          <tr>
            <td class="align-middle"><img style="width:40px; height:40px; object-fit:cover" src="${image != "" ? image : "/img/product-placeholder.png"}" alt="${name}" style="width: 50px;">${name}</td>
            <td class="align-middle">$${price}</td>
            <td class="align-middle">
              <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                  <button data-id="${id}" id="decrement-btn" class="btn btn-sm btn-primary btn-minus">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary text-center" value="${quantity}">
                <div class="input-group-btn">
                  <button data-id="${id}" id="increment-btn" class="btn btn-sm btn-primary btn-plus">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
            </td>
            <td class="align-middle">$${quantity * price}</td>
            <td class="align-middle"><button data-id="${id}" id="remove-btn" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
          </tr>
    `
  return html
}

function updateCartUI() {
  let html = "";

  if (cart.length > 0) {
    cart.forEach(item => {
      html += createCartItemUI(item)
    })
  } else {
    html = "<p>Cart is Empty</p>"
  }

  if (cartBody != null) {
    cartBody.innerHTML = html
    setListeners()
    setCartTotal()
  }
  localStorage.setItem(CART_KEY, JSON.stringify(cart))
}

const saveCart = debounce(saveCartToServer, 3000)
saveCart()

function addProductInCart({ name, id, price, categoryID, image }) {

  if (price == null) {
    console.log("PRODUCT PRICE IS NULL")
    return
  }
  if (findItemInCart(id) !== false) {
    console.log("PRODUCT ALREADY EXISTS IN CART")
    return
  }

  cart.push({ id, name, categoryID, price, quantity: 1, image })
  console.log("PRODUCT ADDED IN CART")
  updateCartCount()
  updateCartUI()
  saveCart()
}

function findItemInCart(id) {
  if (cart.length > 0) {
    for (let i = 0; i < cart.length; ++i) {
      if (cart[i].id == id) {
        return cart[i]
      }
    }
  }

  return false
}


