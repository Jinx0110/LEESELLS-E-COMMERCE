document.addEventListener('DOMContentLoaded', function() {
    fetch('php/getCounts.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // document.getElementById('totalRevenue').textContent = `Total Revenue: ${data.total_revenue}`;
                // document.getElementById('ordersCount').textContent = `Total Orders: ${data.total_orders}`;
                document.getElementById('productsCount').textContent = `Total Products: ${data.total_products}`;
                document.getElementById('customersCount').textContent = `Customers: ${data.total_customers}`;
            } else {
                console.error('Failed to load counts:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching counts:', error);
        });
});

