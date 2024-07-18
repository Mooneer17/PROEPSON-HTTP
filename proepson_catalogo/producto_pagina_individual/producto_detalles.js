document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    if (productId) {
        fetch(`get_product_details.php?id=${productId}`)
            .then(response => response.json())
            .then(producto => {
                if (producto) {
                    const productDetailsDiv = document.getElementById('product-details');
                    productDetailsDiv.innerHTML = `
                        <h1>${producto.nombre}</h1>
                        <p>Price: $${parseFloat(producto.precio).toFixed(2)}</p>
                        <p>Description: ${producto.descripcion}</p>
                        ${producto.descuento > 0 ? `<p>Discount Price: $${(parseFloat(producto.precio) * (1 - producto.descuento / 100)).toFixed(2)} (${producto.descuento}% off)</p>` : ''}
                        <button id="add-to-cart-button">Enviar a carrito</button>
                        
                    `;
                    document.getElementById('add-to-cart-button').addEventListener('click', function() {
                        addToCart(producto);
                    });
                } else {
                    document.getElementById('product-details').textContent = 'Product not found.';
                }
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                document.getElementById('product-details').textContent = 'Error fetching product details.';
            });
    } else {
        document.getElementById('product-details').textContent = 'Invalid product ID.';
    }





    
    function addToCart(producto) {
        fetch('add_to_cart.php', {
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
                alert('Product added to cart');
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error adding product to cart:', error);
        });
    }
});
