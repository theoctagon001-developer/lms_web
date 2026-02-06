<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Management</title>
    @vite('resources/css/app.css')
    <style>
        .password-field {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .toggle-password {
            cursor: pointer;
            background: none;
            border: none;
            margin-left: 5px;
        }
        .edit-icon {
            cursor: pointer;
            margin-left: 8px;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .user-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        .user-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .user-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }
        .user-card .field-value {
            text-align: right;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .user-table {
            min-width: 100%;
            width: auto;
        }
        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            .user-card {
                display: block;
            }
        }
        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }
            .user-card {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
     @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">User Account Management</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Search & Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Search by Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">User Name</label>
                    <input type="text" id="search-name" class="border rounded-lg p-2 w-full" placeholder="Enter user name" 
                           oninput="searchUsers()">
                </div>

                <!-- User Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">User Type</label>
                    <select id="user-type-filter" class="border rounded-lg p-2 w-full" onchange="searchUsers()">
                        <option value="">All Types</option>
                        <option value="Admin">Admin</option>
                        <option value="Datacell">Datacell</option>
                        <option value="Director">Director</option>
                        <option value="HOD">HOD</option>
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="JuniorLecturer">Junior Lecturer</option>
                        <option value="Parent">Parent</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button onclick="resetSearch()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    Reset Filters
                </button>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-table">
            <div class="table-container">
                <table class="user-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Password</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Users will be loaded here -->
                    </tbody>
                </table>
            </div>
            <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                No users found matching your criteria.
            </div>
            <div id="loader" class="loader"></div>
        </div>

        <!-- Mobile Card View -->
        <div id="user-card-container">
            <!-- User cards will be loaded here -->
        </div>
    </div>

    <!-- Email Update Modal -->
    <div id="email-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Email</h3>
                <button onclick="closeModal('email-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Email</label>
                <input type="text" id="current-email" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">New Email</label>
                <input type="email" id="new-email" class="border rounded-lg p-2 w-full" placeholder="Enter new email">
            </div>
            <input type="hidden" id="email-user-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('email-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateEmail()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="email-loader" class="loader"></div>
            <div id="email-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Password Update Modal -->
    <div id="password-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Password</h3>
                <button onclick="closeModal('password-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                <input type="text" id="password-username" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                <div class="password-field">
                    <input type="password" id="new-password" class="border rounded-lg p-2 w-full" placeholder="Enter new password">
                    <button class="toggle-password" onclick="togglePasswordVisibility('new-password')">👁️</button>
                </div>
            </div>
            <input type="hidden" id="password-user-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('password-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updatePassword()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="password-loader" class="loader"></div>
            <div id="password-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
       let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let allUsers = [];
        let filteredUsers = [];

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadUsers() {
            try {
                document.getElementById('loader').style.display = 'block';
                document.getElementById('user-table-body').innerHTML = '';
                document.getElementById('user-card-container').innerHTML = '';
                document.getElementById('no-results').classList.add('hidden');
                
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Datacells/all-users`);
                const data = await response.json();
                
                if (data.data) {
                    allUsers = [];
                    // Convert the nested object structure into a flat array
                    for (const [userType, users] of Object.entries(data.data)) {
                        users.forEach(user => {
                            user.type = userType;
                            allUsers.push(user);
                        });
                    }
                    filteredUsers = [...allUsers];
                    renderUsers();
                }
            } catch (error) {
                console.error("Error fetching users:", error);
                showAlert('error', 'Failed to load users. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function searchUsers() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const typeFilter = document.getElementById("user-type-filter").value;
            
            filteredUsers = allUsers.filter(user => 
                (user.name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (typeFilter === "" || user.type === typeFilter)
            );
            
            renderUsers();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("user-type-filter").value = "";
            filteredUsers = [...allUsers];
            renderUsers();
        }

        function renderUsers() {
            const tableBody = document.getElementById("user-table-body");
            const cardContainer = document.getElementById("user-card-container");
            tableBody.innerHTML = "";
            cardContainer.innerHTML = "";

            if (filteredUsers.length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }

            filteredUsers.forEach(user => {
                // Create password field with toggle
                const passwordField = `
                    <div class="password-field">
                        <span class="password-value" data-password="${user.password}">••••••••</span>
                        <button class="toggle-password" onclick="togglePasswordDisplay(this)">👁️</button>
                        <span class="edit-icon" onclick="openPasswordModal(${user.user_id}, '${user.username}')">✏️</span>
                    </div>
                `;
                
                // Create email field with edit option (always show edit icon)
                const emailField = `
                    <div class="inline-flex items-center">
                        <span>${user.email || 'N/A'}</span>
                        <span class="edit-icon" onclick="openEmailModal(${user.user_id}, '${user.email || ''}')">✏️</span>
                    </div>
                `;
                
                // Add row to desktop table
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            ${user.image ? 
                                `<img src="${user.image}" class="h-10 w-10 rounded-full mr-3 object-cover" alt="${user.name}">` : 
                                `<div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                            <div>
                                <div class="text-sm font-medium text-gray-900">${user.name}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.username}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.type}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${emailField}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${passwordField}</td>
                `;
                tableBody.appendChild(row);
                
                // Add card for mobile view
                const card = document.createElement('div');
                card.className = 'user-card';
                card.innerHTML = `
                    <div class="flex items-center mb-3">
                        ${user.image ? 
                            `<img src="${user.image}" class="h-12 w-12 rounded-full mr-3 object-cover" alt="${user.name}">` : 
                            `<div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                        <div>
                            <div class="font-medium text-gray-900">${user.name}</div>
                            <div class="text-sm text-gray-500">${user.type}</div>
                        </div>
                    </div>
                    <div class="field">
                        <span class="field-label">Username:</span>
                        <span class="field-value">${user.username}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Email:</span>
                        <span class="field-value">
                            ${user.email || 'N/A'}
                            <span class="edit-icon" onclick="openEmailModal(${user.user_id}, '${user.email || ''}')">✏️</span>
                        </span>
                    </div>
                    <div class="field">
                        <span class="field-label">Password:</span>
                        <span class="field-value">
                            <span class="password-value" data-password="${user.password}">••••••••</span>
                            <button class="toggle-password" onclick="togglePasswordDisplay(this)">👁️</button>
                            <span class="edit-icon" onclick="openPasswordModal(${user.user_id}, '${user.username}')">✏️</span>
                        </span>
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }

        function togglePasswordDisplay(button) {
            const passwordValue = button.parentElement.querySelector('.password-value');
            const currentDisplay = passwordValue.textContent;
            
            if (currentDisplay === '••••••••') {
                passwordValue.textContent = passwordValue.getAttribute('data-password');
            } else {
                passwordValue.textContent = '••••••••';
            }
        }

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }

        function openEmailModal(userId, currentEmail) {
            document.getElementById('current-email').value = currentEmail || 'N/A';
            document.getElementById('new-email').value = currentEmail || '';
            document.getElementById('email-user-id').value = userId;
            document.getElementById('email-message').classList.add('hidden');
            document.getElementById('email-modal').style.display = 'flex';
        }

        function openPasswordModal(userId, username) {
            document.getElementById('password-username').value = username;
            document.getElementById('new-password').value = '';
            document.getElementById('password-user-id').value = userId;
            document.getElementById('password-message').classList.add('hidden');
            document.getElementById('password-modal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        async function updateEmail() {
            const userId = document.getElementById('email-user-id').value;
            const newEmail = document.getElementById('new-email').value.trim();
            
            if (!newEmail) {
                showMessage('email-message', 'Please enter a valid email address.', 'error');
                return;
            }
            
            try {
                document.getElementById('email-loader').style.display = 'block';
                document.getElementById('email-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Datacells/update-email`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        email: newEmail
                    })
                });
                
                const data = await response.json();
                
                if (data.status === true) {
                    showMessage('email-message', 'Email updated successfully!', 'success');
                    // Update the user data in our local array
                    const userIndex = allUsers.findIndex(u => u.user_id == userId);
                    if (userIndex !== -1) {
                        allUsers[userIndex].email = newEmail;
                        renderUsers();
                    }
                    // Close modal after 2 seconds
                    setTimeout(() => closeModal('email-modal'), 2000);
                } else {
                    showMessage('email-message', data.message || 'Failed to update email.', 'error');
                }
            } catch (error) {
                console.error('Error updating email:', error);
                showMessage('email-message', 'An error occurred while updating email.', 'error');
            } finally {
                document.getElementById('email-loader').style.display = 'none';
            }
        }

        async function updatePassword() {
            const userId = document.getElementById('password-user-id').value;
            const newPassword = document.getElementById('new-password').value.trim();
            
            if (!newPassword) {
                showMessage('password-message', 'Please enter a new password.', 'error');
                return;
            }
            
            if (newPassword.length < 6) {
                showMessage('password-message', 'Password must be at least 6 characters.', 'error');
                return;
            }
            
            try {
                document.getElementById('password-loader').style.display = 'block';
                document.getElementById('password-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Datacells/update-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        password: newPassword
                    })
                });
                
                const data = await response.json();
                
                if (data.status === true) {
                    showMessage('password-message', 'Password updated successfully!', 'success');
                    // Update the user data in our local array
                    const userIndex = allUsers.findIndex(u => u.user_id == userId);
                    if (userIndex !== -1) {
                        allUsers[userIndex].password = newPassword;
                        renderUsers();
                    }
                    // Close modal after 2 seconds
                    setTimeout(() => closeModal('password-modal'), 2000);
                } else {
                    showMessage('password-message', data.message || 'Failed to update password.', 'error');
                }
            } catch (error) {
                console.error('Error updating password:', error);
                showMessage('password-message', 'An error occurred while updating password.', 'error');
            } finally {
                document.getElementById('password-loader').style.display = 'none';
            }
        }

        function showMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.classList.remove('hidden');
            
            if (type === 'success') {
                element.className = element.className.replace(/text-red-500/g, '') + ' text-green-500';
            } else {
                element.className = element.className.replace(/text-green-500/g, '') + ' text-red-500';
            }
        }

        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        document.addEventListener("DOMContentLoaded", loadUsers);
    </script>

    @include('components.footer')
</body>

</html>