const API_URL = "http://localhost:8000/api/products";

const productForm = document.getElementById("productForm");
const productTable = document.getElementById("productTable");
const productIdInput = document.getElementById("productId");
const nameInput = document.getElementById("name");
const priceInput = document.getElementById("price");
const descriptionInput = document.getElementById("description");

async function loadProducts() {
    try {
      const response = await fetch(API_URL);
      const products = await response.json(); 
  
      if (!Array.isArray(products)) {
        alert("Error: La respuesta no es válida.");
        return;
      }
  
      productTable.innerHTML = products
        .map(
          (product) => `
          <tr>
            <td>${product.name}</td>
            <td>${parseFloat(product.price).toFixed(2)}</td>
            <td>${product.description || "Sin descripción"}</td>
            <td class="action-buttons">
              <button onclick="editProduct(${product.id})">Editar</button>
              <button onclick="deleteProduct(${product.id})">Eliminar</button>
            </td>
          </tr>
        `
        )
        .join("");
    } catch (error) {
      alert("Error al cargar los productos: " + error.message);
    }
  }
  
async function saveProduct(event) {
  event.preventDefault();

  const id = productIdInput.value;
  const productData = {
    name: nameInput.value.trim(),
    price: parseFloat(priceInput.value),
    description: descriptionInput.value.trim(),
  };

  try {
    const response = await fetch(id ? `${API_URL}/${id}` : API_URL, {
      method: id ? "PUT" : "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(productData),
    });

    const { headerStatus, message, data, success } = await response.json();

    if (!success) {
      alert(message);
      return;
    }

    alert(message);
    productForm.reset();
    productIdInput.value = "";
    await loadProducts();
  } catch (error) {
    alert("Error al guardar el producto: " + error.message);
  }
}

async function editProduct(id) {
  try {
    const response = await fetch(`${API_URL}/${id}`);
    const { headerStatus, data, message, success } = await response.json();

    if (!success) {
      alert(message);
      return;
    }

    const product = data;
    productIdInput.value = product.id;
    nameInput.value = product.name;
    priceInput.value = product.price;
    descriptionInput.value = product.description || "";
  } catch (error) {
    alert("Error al cargar el producto para edición: " + error.message);
  }
}

async function deleteProduct(id) {
  if (confirm("¿Estás seguro de eliminar este producto?")) {
    try {
      const response = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
      const { headerStatus, message, success } = await response.json();

      if (!success) {
        alert(message);
        return;
      }

      alert(message);
      await loadProducts();
    } catch (error) {
      alert("Error al eliminar el producto: " + error.message);
    }
  }
}

productForm.addEventListener("submit", saveProduct);
loadProducts();
