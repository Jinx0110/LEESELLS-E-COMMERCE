function displayUsername(){
        // Fetch the username from PHP file
        fetch('php/getUsername.php')
            .then(response => response.json())
            .then(data => {
                if (data.username) {
                    document.getElementById('userNameDisplay').textContent = data.username;
                   
                } else {
                    document.getElementById('userNameDisplay').textContent = 'Guest';
                }
            })
            .catch(error => console.error('Error fetching username:', error));
    
}
document.addEventListener('DOMContentLoaded', displayUsername);