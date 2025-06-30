function openEditUserModal(userID){
    const user = allUsers.find(u => u.user_id == userID);

    if (!user){
        alert ('User not found');
        return;
    } 

    document.getElementById('editUserId').value = user.user_id;
    document.getElementById('newUsername').value = user.username;
    document.getElementById('newEmail').value = user.email;
    document.getElementById('newRole').value = user.role;

    document.getElementById('editUserModal').style.display = 'flex';
}

function closeEditUserModal(){
    document.getElementById('editUserForm').reset();
    document.getElementById('editUserModal').style.display = 'none';
}

document.getElementById('editUserForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission (page reload)

    const user_id = document.getElementById('editUserId').value;
    const username = document.getElementById('newUsername').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const role = document.getElementById('newRole').value;

    // Send updated data to your backend PHP script (adjust URL as needed)
    fetch('php/updateUser.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ user_id, username, email, role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User updated successfully!');
            closeEditUserModal();  // Close modal
            fetchUsers();          // Refresh user list (make sure fetchUsers() is globally accessible)
        } else {
            alert('Failed to update user: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Network error: ' + error);
    });
});


function openAddNewUserModal(userID){
    const user = allUsers.find(u => u.user_id == userID);

  
    document.getElementById('editUserId').value = user.user_id;
    document.getElementById('newUsername').value = user.username;
    document.getElementById('newEmail').value = user.email;
    document.getElementById('newRole').value = user.role;

    document.getElementById('editUserModal').style.display = 'flex';
}


function openAddNewProductModal() {
  document.getElementById('addProductModal').style.display = 'flex';
}

function closeAddProductModal() {
  document.getElementById('addProductForm').reset();
  document.getElementById('addProductModal').style.display = 'none';
}
