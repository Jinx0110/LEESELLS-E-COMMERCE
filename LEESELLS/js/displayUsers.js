let allUsers = [];

function fetchUsers() {
    fetch('php/fetchUsers.php')
        .then(response => response.json())
        .then(users => {
            allUsers = users;
            renderUsers(allUsers);
        })
        .catch(error => {
            console.error('Error fetching users: ', error);
            document.getElementById('usersTableBody').innerHTML = '<tr><td colspan="5" style="color:red;">Failed to load users.</td></tr>';
        });
}

function renderUsers(users) {
    const tbody = document.getElementById('usersTableBody');
    tbody.innerHTML = '';
    if(!users.length){
        tbody.innerHTML = '<tr><td colspan = "5">No users found.</td></tr>';
        return;
    }
    users.forEach(user => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${user.user_id}</td>
            <td>${user.username}</td> 
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td>
                <button type="button" onclick="openEditUserModal(${user.user_id})" class="btn-edit" style = "cursor: pointer;">Edit</button>   
                <button type="button" onclick="openDeleteUserModal(${user.user_id}, '${user.username}')" class="btn-delete">Delete</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}


function filterUsers(){
const selectedRole = document.getElementById('roleFilter').value;
    if(selectedRole === 'all'){
        renderUsers(allUsers);
    } else{
        const filtered = allUsers.filter(user => user.role.toLowerCase() === selectedRole.toLowerCase());
        renderUsers(filtered);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchUsers(); // Ensure this is called to load users
});

