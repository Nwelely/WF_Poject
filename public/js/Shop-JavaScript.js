let cart = [];
async function fetchProducts() {
  const productsData = [
    { id: 1, name: "gym bottle", price: 10.99, image: "../public/images/Gym_bottle3.jpg" },
    { id: 2, name: "steel fusion", price: 29.99, image: "../public/images/Images/1.jpg" },
    { id: 3, name: "creatine", price: 39.99, image: "../public/images/Creatine.jpg" },
    { id: 4, name: "BCAA", price: 49.99, image: "../public/images/6.webp" },
    { id: 5, name: "black steel", price: 49.99, image: "../public/images/8.webp" },
    { id: 6, name: "dumbells", price: 121.99, image: "../public/images/dumbells.jpg" },
    { id: 7, name: "big gym bottle", price: 29.99, image: "../public/images/gym_bottle_big.webp" },
    { id: 8, name: "gym mat", price: 9.99, image: "../public/images/gym mat.avif" },
    { id: 9, name: "gym shorts", price: 8.99, image: "../public/images/gym shorts.jpg" },
    { id: 10, name: "mid gym bottle", price: 19.99, image: "../public/images/gym_bottle_mid.webp" },
    { id: 11, name: "small gym bottle", price: 9.99, image: "../public/images/gym_bottle_small.webp" },
    { id: 12, name: "gym bottle", price: 7.99, image: "../public/images/Gym_bottle2.jpg" },
    { id: 13, name: "Product 13", price: 69.99, image: "../public/images/Protein powder.jpg" },
    { id: 14, name: "pre workout", price: 29.99, image: "../public/images/pre workout.jpg" },
    { id: 15, name: "training tshirt", price: 17.99, image: "../public/images/training tshirts.jpg" },
    { id: 16, name: "BCAA", price: 47.99, image: "../public/images/BCA.jpg" },
    { id: 17, name: "gym bottle", price: 12.99, image: "../public/images/Gym_bottle3.png" },


  ];
  return productsData;
}
async function generateProductCards() {
  const productContainer = document.querySelector(".product-list");
  const products = await fetchProducts();
  products.forEach((product) => {
    const cardExists = productContainer.querySelector(
      `[data-id="${product.id}"]`
    );
    if (!cardExists) {
      const card = document.createElement("div");
      card.classList.add("product-card");
      card.dataset.id = product.id;
      const image = document.createElement("img");
      image.src = product.image;
      image.alt = product.name;
      const name = document.createElement("h3");
      name.textContent = product.name;
      const price = document.createElement("p");
      price.textContent = `$${product.price}`;
      const addToCartBtn = document.createElement("button");
      addToCartBtn.textContent = "Add to Cart";
      addToCartBtn.addEventListener("click", () => {
        addToCart(product);
      });
      card.appendChild(image);
      card.appendChild(name);
      card.appendChild(price);
      card.appendChild(addToCartBtn);
      productContainer.appendChild(card);
    }
  });
}
function updateCartUI() {
  const cartCount = document.querySelector(".cart-count");
  const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
  cartCount.textContent = totalQuantity.toString();
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
function displayCart() {
  const cartContainer = document.querySelector(".cart-items");
  
  cartContainer.innerHTML = "";
  let totalPrice = 0;
  if (cart.length === 0) {
    cartContainer.textContent = "Your cart is empty.";
  } else {
    cart.forEach((item) => {
      const cartItem = document.createElement("div");
      cartItem.classList.add("cart-item");
      const productImage = document.createElement("img");
      productImage.src = item.image;
      productImage.alt = item.name;
      productImage.classList.add("cart-item-img");
      cartItem.appendChild(productImage);
      const itemDetails = document.createElement("div");
      itemDetails.classList.add("cart-item-info");
      const itemNamePrice = document.createElement("span");
      itemNamePrice.textContent = `${item.name} - $${item.price}`;
      itemNamePrice.classList.add("cart-item-name-price");
      itemDetails.appendChild(itemNamePrice);
      const itemCount = document.createElement("span");
      itemCount.textContent = `Quantity: ${item.quantity}`;
      itemCount.classList.add("cart-item-quantity");
      itemDetails.appendChild(itemCount);
      const itemButtons = document.createElement("div");
      itemButtons.classList.add("cart-item-buttons");
      const PlusBtn = document.createElement("button");
      PlusBtn.textContent = "+";
      PlusBtn.addEventListener("click", () => {
        addToCart(item);
      });
      itemButtons.appendChild(PlusBtn);
      const MinusBtn = document.createElement("button");
      MinusBtn.textContent = "-";
      MinusBtn.addEventListener("click", () => {
        removeFromCart(item);
      });
      itemButtons.appendChild(MinusBtn);
      const RemoveBtn = document.createElement("button");
      RemoveBtn.textContent = "Remove";
      RemoveBtn.addEventListener("click", () => {
        removeAllFromCart(item);
      });
      itemButtons.appendChild(RemoveBtn);
      itemDetails.appendChild(itemButtons);
      cartItem.appendChild(itemDetails);
      cartContainer.appendChild(cartItem);
      totalPrice += item.price * item.quantity;
    });
  }
  const cartTotalElement = document.querySelector("#cart-total");
  cartTotalElement.textContent = `Total: $${totalPrice.toFixed(2)}`;
}
function removeAllFromCart(item) {
  cart = cart.filter((cartItem) => cartItem.id !== item.id);
  updateCartUI();
  displayCart();
}
generateProductCards();
function checkout() {
  if (cart.length === 0) {
    alert("Your cart is empty. Add products to your cart first.");
  } else {
    alert("Redirecting to checkout page...");
    cart = [];
    updateCartUI();
    displayCart();
  }
}
generateProductCards();
document.addEventListener("DOMContentLoaded", function () {
  const cartBtn = document.querySelector("#cart-Btn");
  const cartOverlay = document.querySelector("#cart-overlay");
  const cartCloseBtn = document.querySelector("#cart-close");
  const cartSymbol = document.querySelector(".cart-count"); 
  cartBtn.addEventListener("click", function () {
    cartOverlay.style.display = "flex"; 
    document.body.style.overflow = "hidden"; 
  });
  cartSymbol.addEventListener("click", function () {
    cartOverlay.style.display = "flex"; 
    document.body.style.overflow = "hidden"; 
  });
  cartCloseBtn.addEventListener("click", function () {
    cartOverlay.style.display = "none"; 
    document.body.style.overflow = ""; 
  });
  const checkoutBtnCart = document.querySelector("#checkout-btn-cart");
  checkoutBtnCart.addEventListener("click", checkout);
});
function checkout() {
  if (cart.length === 0) {
    alert("Your cart is empty. Add products to your cart first.");
  } else {
    alert("Redirecting to checkout page...");
    cart = []; // Clear the cart after checkout
    updateCartUI();
    displayCart();
  }
}
generateProductCards(); 