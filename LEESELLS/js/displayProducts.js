let allProducts = [];

function editProduct(productId){
    // Your edit product logic here (if needed)
}

function addProductRow(product) {
    const tableBody = document.getElementById('productsTableBody');
    const row = document.createElement('tr');

    // Adjust the following to match your table columns
    row.innerHTML = `
        <td>${product.product_id}</td>
        <td>${product.name}</td>
        <td>${product.price}</td>
        <td>${product.category}</td>
        <td>${product.seller_id}</td>
        <td>
            <button onclick="editProduct(${product.product_id})">Edit</button>
        </td>
    `;
    tableBody.appendChild(row);
}

function loadProducts() {
    fetch('php/retrieveProducts.php')
        .then(response => response.json())
        .then(products => {
            allProducts = products; // Store products in the global variable
              tableBody.innerHTML = '';
            products.forEach(product => {
                addProductRow(product); // Add each product to the table
            });
        })
        .catch(err => {
            console.error('Failed to load products:', err);
            alert('Failed to load products.');
        });
}


// Display sellers and handle form submission after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    fetch('php/getSellers.php')
        .then(response => response.json())
        .then(sellers => {
            const select = document.getElementById('sellerSelect');
            sellers.forEach(seller => {
                const option = document.createElement('option');
                option.value = seller.user_id;
                option.textContent = seller.username;
                select.appendChild(option);
            });
        })
        .catch(err => {
            alert('Failed to load sellers.');
        });
});

document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('php/addProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if(data.success) {
                closeAddProductModal();
                if (data.product) {
                    addProductRow(data.product); // Add new row to table
                }
            }
        })
        .catch(err => alert('Error: ' + err));
    });

document.addEventListener('DOMContentLoaded', function() {
    loadProducts(); // Ensure this is called to load products
});