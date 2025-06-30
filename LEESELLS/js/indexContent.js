document.addEventListener('DOMContentLoaded', () => {
    const productList = document.getElementById('productList');

    fetch('php/retrieveProducts.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(products => {
            if (products.error) {
                productList.innerHTML = `<p>Error: ${products.error}</p>`;
                return;
            }

            productList.innerHTML = ''; 

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.style.border = '1px solid #ddd';
                productCard.style.padding = '15px';
                productCard.style.width = '200px';
                productCard.style.textAlign = 'center';

                productCard.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" style="max-width:100%; height:auto;"/>
                    <h3>${product.name}</h3>
                    <p>Seller: ${product.seller}</p>
                    <p>Price: R${product.price}</p>
                `;

                productList.appendChild(productCard);
            });
        })
        .catch(error => {
            productList.innerHTML = `<p>Failed to load products: ${error.message}</p>`;
            console.error('Error fetching products:', error);
        });
});
