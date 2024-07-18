document.addEventListener("DOMContentLoaded", function() {
    var categoryButtonsDiv = document.getElementById("category-buttons");
    var productsDiv = document.getElementById("products");

    function fetchProducts(categoriaId) {
        var url = "get_products.php";
        if (categoriaId) {
            url += "?categoria_id=" + encodeURIComponent(categoriaId);
        }
        fetch(url)
            .then(response => response.json())
            .then(productos => {
                displayProducts(productos);
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    function displayProducts(productos) {
        productsDiv.innerHTML = "";
        productos.forEach(function(producto) {
            var productElement = document.createElement("div");
            productElement.className = "producto";

            var nombreElement = document.createElement("div");
            nombreElement.className = "nombre";
            nombreElement.textContent = producto.nombre;
            productElement.appendChild(nombreElement);

            var precioElement = document.createElement("div");
            precioElement.className = "precio";
            precioElement.textContent = producto.precio;
            productElement.appendChild(precioElement);

            if (producto.descuento && producto.descuento > 0) {
                var discountedPrice = producto.precio * (1 - producto.descuento / 100);
                var descuentoElement = document.createElement("div");
                descuentoElement.className = "descuento";
                descuentoElement.textContent = `Discount Price: $${discountedPrice.toFixed(2)} (${producto.descuento}% off)`;
                productElement.appendChild(descuentoElement);
            }

            var descripcionElement = document.createElement("div");
            descripcionElement.className = "descripcion";
            descripcionElement.textContent = producto.descripcion;
            productElement.appendChild(descripcionElement);

            // Add "See More" button
            var seeMoreButton = document.createElement("button");
            seeMoreButton.className = "see-more";
            seeMoreButton.textContent = "Ver producto";
            seeMoreButton.onclick = function() {
                window.location.href = `producto_pagina_individual/producto_detalles.html?id=${producto.id}`;
            };
            productElement.appendChild(seeMoreButton);

            // Add "Add to Cart" button
            var addToCartButton = document.createElement("button");
            addToCartButton.className = "add-to-cart";
            addToCartButton.textContent = "Añadir a mi carrito";
            addToCartButton.onclick = function() {
                addToCart(producto);
            };
            productElement.appendChild(addToCartButton);

            // Add "Buy Now" button
            var buyNowButton = document.createElement("button");
            buyNowButton.className = "buy-now";
            buyNowButton.textContent = "Compra ahora";
            buyNowButton.onclick = function() {
                alert(`Fuiste a comprar ${producto.nombre}`);
            };
            productElement.appendChild(buyNowButton);

            productsDiv.appendChild(productElement);
        });
    }

    function fetchCategories() {
        fetch("get_categories.php")
            .then(response => response.json())
            .then(categorias => {
                // Botón "All"
                var allButton = document.createElement("button");
                allButton.classList.add("category-button");
                allButton.textContent = "All";
                allButton.addEventListener("click", function() {
                    fetchProducts();
                });
                categoryButtonsDiv.appendChild(allButton);

                // Botones de categorías
                categorias.forEach(function(category) {
                    var button = document.createElement("button");
                    button.classList.add("category-button");
                    button.textContent = category.nombre;
                    button.dataset.categoryId = category.id;
                    button.addEventListener("click", function() {
                        fetchProducts(category.id);
                    });
                    categoryButtonsDiv.appendChild(button);
                });
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
            });
    }

    fetchCategories();
    fetchProducts();
});

function addToCart(producto) {
    fetch('producto_pagina_individual/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            cantidad: 1 // Puedes modificar esto según sea necesario
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto añadido al carrito');
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error añadiendo producto al carrito:', error);
    });
}
