if (typeof window !== "undefined") {
  document.addEventListener("DOMContentLoaded", () => {
    const btnAdd = document.querySelectorAll(".add-button");
    const cartSidebar = document.getElementById("cartSidebar");
    const cartItems = document.getElementById("cartItems");
    const cartTotal = document.getElementById("cartTotal");
    const closeCart = document.getElementById("closeCart");
    const payButton = document.getElementById("payButton");
    const mainContent = document.getElementById("mainContent");
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    btnAdd.forEach((button) => {
      button.addEventListener("click", async () => {
        const itemId = parseInt(button.getAttribute("data-id"), 10); // Convertir el ID a entero
        const itemDetails = await getItemDetails(itemId);
        addItemToCart(itemDetails);
        showCart();
      });
    });

    closeCart.addEventListener("click", () => {
      cartSidebar.classList.remove("open");
      mainContent.classList.remove("shifted");
    });

    payButton.addEventListener("click", async () => {
      await processPayment();
    });

    async function getItemDetails(id) {
      // Simulación de una llamada a la base de datos para obtener los detalles del producto
      const response = await fetch(`getItemDetails.php?id=${id}`);
      const data = await response.json();
      return data;
    }

    function addItemToCart(item) {
      const existingItem = cart.find((cartItem) => cartItem.id === item.id);
      if (existingItem) {
        existingItem.quantity++;
        existingItem.subtotal = existingItem.quantity * existingItem.price;
      } else {
        cart.push({ ...item, quantity: 1, subtotal: item.price });
      }
      localStorage.setItem("cart", JSON.stringify(cart));
      renderCart();
    }

    function updateItemQuantity(id, change) {
      const item = cart.find((cartItem) => cartItem.id === id);
      if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
          cart = cart.filter((cartItem) => cartItem.id !== id);
        } else {
          item.subtotal = item.quantity * item.price;
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
      }
    }

    function renderCart() {
      cartItems.innerHTML = "";
      let total = 0;
      cart.forEach((item) => {
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");
        cartItem.innerHTML = `
                      <img src="${item.img}.jpg" alt="${item.name}">
                      <div>
                          <h4>${item.name}</h4>
                          <div class="quantity-controls">
                              <button class="decrease" data-id="${
                                item.id
                              }">-</button>
                              <span>Cantidad: ${item.quantity}</span>
                              <button class="increase" data-id="${
                                item.id
                              }">+</button>
                          </div>
                          <p>Subtotal: $${item.subtotal.toFixed(2)}</p>
                      </div>
                  `;
        cartItems.appendChild(cartItem);
        total += item.subtotal;
      });
      cartTotal.innerHTML = `Total: $${total.toFixed(2)}`;

      // Añadir eventos a los botones de aumentar y disminuir cantidad
      const increaseButtons = document.querySelectorAll(".increase");
      const decreaseButtons = document.querySelectorAll(".decrease");

      increaseButtons.forEach((button) => {
        button.addEventListener("click", () => {
          const itemId = parseInt(button.getAttribute("data-id"), 10);
          updateItemQuantity(itemId, 1);
        });
      });

      decreaseButtons.forEach((button) => {
        button.addEventListener("click", () => {
          const itemId = parseInt(button.getAttribute("data-id"), 10);
          updateItemQuantity(itemId, -1);
        });
      });
    }

    async function processPayment() {
      const response = await fetch("processPayment.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(cart),
      });

      if (response.ok) {
        alert("Pago realizado con éxito");
        cart = [];
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        cartSidebar.classList.remove("open");
        mainContent.classList.remove("shifted");
      } else {
        alert("Error al procesar el pago");
      }
    }

    function showCart() {
      cartSidebar.classList.add("open");
      mainContent.classList.add("shifted");
    }

    renderCart();
  });
}
