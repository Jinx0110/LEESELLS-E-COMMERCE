document.addEventListener('DOMContentLoaded', () => {
    const containerProducts = document.getElementById("containerProducts");

    fetch('php/retrieveProducts.php')
        .then(response => {
            if (!response.ok) throw new Error("Network error");
            return response.json();
        })
        .then(products => {
            containerProducts.innerHTML = '';
            products.forEach(product => {
                containerProducts.appendChild(dynamicProductSection(product));
            });
        })
        .catch(err => {
            console.error("Error loading products:", err);
            containerProducts.innerHTML = `<p>Failed to load products.</p>`;
        });
});

function dynamicProductSection(product) {
    let boxDiv = document.createElement("div");
    boxDiv.className = "box";

    let boxLink = document.createElement("a");
    boxLink.href = "/contentDetails.html?" + (product.id || '');

    let imgTag = document.createElement("img");
    imgTag.src = product.image;
    imgTag.alt = product.name;

    let detailsDiv = document.createElement("div");
    detailsDiv.className = "details";

    let name = document.createElement("h3");
    name.textContent = product.name;

    let seller = document.createElement("h4");
    seller.textContent = "Seller: " + product.seller;

    let price = document.createElement("h2");
    price.textContent = "R " + product.price;

    boxDiv.appendChild(boxLink);
    boxLink.appendChild(imgTag);
    boxLink.appendChild(detailsDiv);
    detailsDiv.appendChild(name);
    detailsDiv.appendChild(seller);
    detailsDiv.appendChild(price);

    return boxDiv;
}
