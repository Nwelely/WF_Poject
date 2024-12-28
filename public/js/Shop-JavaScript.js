let cart = [];

function updateCartUI() {
  const cartCount = document.querySelector(".cart-count");
  const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
  cartCount.textContent = totalQuantity;
}

function addToCart(product) {
  const existingItem = cart.find((item) => item.id === product.id);
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({ ...product, quantity: 1 });
  }
  updateCartUI();
  displayCart();
}

function removeFromCart(item) {
  const itemIndex = cart.findIndex((cartItem) => cartItem.id === item.id);
  if (itemIndex !== -1) {
    if (cart[itemIndex].quantity > 1) {
      cart[itemIndex].quantity--;
    } else {
      cart.splice(itemIndex, 1);
    }
    updateCartUI();
    displayCart();
  }
}

function removeAllFromCart(item) {
  cart = cart.filter((cartItem) => cartItem.id !== item.id);
  updateCartUI();
  displayCart();
}

function displayCart() {
  const cartContainer = document.querySelector("#cart-items");
  cartContainer.innerHTML = "";

  let totalPrice = 0;

  if (cart.length === 0) {
    cartContainer.textContent = "Your cart is empty.";
  } else {
    cart.forEach((item) => {
      const cartItem = document.createElement("div");
      cartItem.classList.add("cart-item");

      const productImage = document.createElement("img");
      productImage.src = item.image || "../public/images/default-product.jpg";
      productImage.alt = item.name;

      const itemDetails = document.createElement("div");
      itemDetails.classList.add("cart-item-info");

      const nameAndPrice = document.createElement("span");
      nameAndPrice.textContent = `${item.name} - $${item.price.toFixed(2)}`;
      itemDetails.appendChild(nameAndPrice);

      const quantity = document.createElement("span");
      quantity.textContent = `Quantity: ${item.quantity}`;
      itemDetails.appendChild(quantity);

      const buttons = document.createElement("div");
      buttons.classList.add("cart-item-buttons");

      const plusBtn = document.createElement("button");
      plusBtn.textContent = "+";
      plusBtn.addEventListener("click", () => addToCart(item));
      buttons.appendChild(plusBtn);

      const minusBtn = document.createElement("button");
      minusBtn.textContent = "-";
      minusBtn.addEventListener("click", () => removeFromCart(item));
      buttons.appendChild(minusBtn);

      const removeBtn = document.createElement("button");
      removeBtn.textContent = "Remove";
      removeBtn.addEventListener("click", () => removeAllFromCart(item));
      buttons.appendChild(removeBtn);

      itemDetails.appendChild(buttons);
      cartItem.appendChild(productImage);
      cartItem.appendChild(itemDetails);

      cartContainer.appendChild(cartItem);

      totalPrice += item.price * item.quantity;
    });
  }

  const cartTotalElement = document.querySelector("#cart-total");
  cartTotalElement.textContent = `Total: $${totalPrice.toFixed(2)}`;
}

function initializeCartButtons() {
  const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

  addToCartButtons.forEach((button) => {
    const product = {
      id: parseInt(button.dataset.id),
      name: button.dataset.name,
      price: parseFloat(button.dataset.price),
      image: "../public/images/default-product.jpg", // Placeholder image
    };

    button.addEventListener("click", () => addToCart(product));
  });
}

function checkout() {
  if (cart.length === 0) {
    alert("Your cart is empty. Add products to your cart first.");
  } else {
    window.location.href = "http://localhost/WF_Poject/app/views/Payment.php";
    cart = [];
    updateCartUI();
    displayCart();
  }
}

document.addEventListener("DOMContentLoaded", () => {

  initializeCartButtons();

  const cartinfo = document.querySelector("#cartinfo");
  const cartOverlay = document.querySelector("#cart-overlay");
  const cartCloseBtn = document.querySelector("#cart-close");
  const checkoutBtn = document.querySelector("#checkout-btn-cart");

  cartinfo.addEventListener("click", () => {
    cartOverlay.style.display = "flex";
    document.body.style.overflow = "hidden";
  });

  cartCloseBtn.addEventListener("click", () => {
    cartOverlay.style.display = "none";
    document.body.style.overflow = "";
  });

  checkoutBtn.addEventListener("click", checkout);
});
