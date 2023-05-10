const CART_KEY = "cart"

const EventListeners = {
  "increment-btn": (id) => increaseQuantity(id),
  "decrement-btn": (id) => decreaseQuantity(id),
  "remove-btn": (id) => removeItemFromCart(id)
}

const items = [
  {
    name: "Esports Sportswear",
    category: "Sportswear",
    image: "/client/img/product-1.jpg",
    price: 200,
    quantity: 1,
    id: 1
  }, {
    name: "Esports Sportswear",
    category: "Sportswear",
    image: "/client/img/product-1.jpg",
    price: 200,
    quantity: 1,
    id: 2
  }, {
    name: "Esports Sportswear",
    category: "Sportswear",
    image: "/client/img/product-1.jpg",
    price: 200,
    quantity: 1,
    id: 3
  }
]

const cart = JSON.parse(localStorage.getItem(CART_KEY)) || items
const cartCountElement = document.querySelector("#cart-item-count")
updateCartCount()

const cartBody = document.querySelector("#cart-body")
updateCartUI()

function attachListener(btn) {
  const id = btn.dataset.id
  btn.addEventListener("click", ()=>EventListeners[btn.id](id))
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
}

function decreaseQuantity(id) {
  const item = findItemInCart(id)
  if (item.quantity == 0) {
    return;
  }
  item.quantity -= 1
  updateCartUI()
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
}

function createCartItemUI({ id, name, quantity, price, image }) {
  const html = `
          <tr>
            <td class="align-middle"><img src="${image}" alt="${name}" style="width: 50px;">${name}</td>
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

  cartBody.innerHTML = html
  localStorage.setItem(CART_KEY,JSON.stringify(cart)) 
  setListeners()
}

function addProductInCart({ name, id, price, categoryID }) {

  if (findItemInCart(id) !== false) return

  cart.push({ id, name, categoryID, price, quantity: 1 })
  updateCartCount()
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


