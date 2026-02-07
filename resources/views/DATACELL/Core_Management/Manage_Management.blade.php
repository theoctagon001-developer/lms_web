<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Management Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Base styles */
        .table-container {
            transition: all 0.3s ease-in-out;
        }

        /* Action buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            margin: 0 2px;
        }

        .edit-btn {
            background-color: #f59e0b;
            color: white;
        }

        .delete-btn {
            background-color: #ef4444;
            color: white;
        }

        /* Top action buttons */
        .top-actions {
            display: flex;
            justify-content: flex-start;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .top-actions button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-admin-btn {
            background-color: #10b981;
            color: white;
        }

        .add-datacell-btn {
            background-color: #3b82f6;
            color: white;
        }

        .add-hod-btn {
            background-color: #8b5cf6;
            color: white;
        }

        .add-director-btn {
            background-color: #ec4899;
            color: white;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            border-radius: 0.25rem;
        }

        .pagination-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 1.5rem;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Alert messages */
        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .alert-close {
            cursor: pointer;
            font-weight: bold;
        }

        /* Loader */
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

        /* Mobile-first table transformation */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 1.5rem;
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                background-color: white;
            }

            td {
                border: none;
                position: relative;
                padding-left: 45% !important;
                text-align: left !important;
                min-height: 45px;
                display: flex;
                align-items: center;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 0.75rem;
                width: 45%;
                padding-right: 0.5rem;
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
                color: #333;
            }

            td:first-child {
                padding-left: 0 !important;
                display: flex;
                justify-content: center;
                padding-top: 1rem;
                padding-bottom: 0.5rem;
            }

            td:first-child:before {
                display: none;
            }

            td:last-child {
                padding: 0.75rem !important;
                display: flex;
                justify-content: center;
                gap: 0.5rem;
            }

            td:last-child:before {
                display: none;
            }

            .top-actions {
                justify-content: center;
            }

            .top-actions button {
                width: 100%;
                justify-content: center;
            }

            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 mb-4">Manage Management Staff</h2>

        <div class="top-actions">
            <button class="add-admin-btn" onclick="window.location.href='{{ route('datacell.add.admin') }}'">
                📝 Add Admin
            </button>
            <button class="add-datacell-btn" onclick="window.location.href='{{ route('datacell.add.datacell') }}'">
                📝 Add Datacell
            </button>
            <button class="add-hod-btn" onclick="window.location.href='{{ route('datacell.add.hod') }}'">
                📝 Add HOD
            </button>
            <button class="add-director-btn" onclick="window.location.href='{{ route('datacell.add.director') }}'">
                📝 Add Director
            </button>
        </div>

        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4">
            <select id="user-type-filter" class="border p-2 w-full sm:w-64" onchange="filterUsers()">
                <option value="All">All Types</option>
                <option value="Admin">Admin</option>
                <option value="Datacell">Datacell</option>
                <option value="HOD">HOD</option>
                <option value="Director">Director</option>
            </select>
            <select id="items-per-page" class="border p-2 w-full sm:w-36" onchange="changeItemsPerPage()">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
            <button onclick="resetFilters()" class="bg-gray-500 text-white px-4 py-2 rounded">
                🔄 Refresh
            </button>
        </div>

        <!-- Alert container for messages -->
        <div id="alert-container" class="mb-4"></div>

        <div class="table-container mx-auto w-full">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Designation</th>
                        <th class="px-4 py-2">Department</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="loader" id="loader"></div>

        <div class="pagination-container">
            <button id="first-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                ◀◀
            </button>
            <button id="prev-page" class="pagination-btn" onclick="prevPage()" disabled>
                ◀
            </button>
            <span id="page-info" class="px-2">Page 1 of 1</span>
            <button id="next-page" class="pagination-btn" onclick="nextPage()" disabled>
                ▶
            </button>
            <button id="last-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                ▶▶
            </button>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="text-xl font-bold mb-4" id="edit-modal-title">Edit User</h3>
            <form id="editUserForm">
                <input type="hidden" id="edit-user-id">
                <input type="hidden" id="edit-user-type">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit-designation">Designation</label>
                        <input type="text" id="edit-designation" name="Designation">
                    </div>
                    <div class="form-group" id="department-container" style="display: none;">
                        <label for="edit-department">Department</label>
                        <select id="edit-department" name="program_name">
                            <option value="BCS">BCS</option>
                            <option value="BSE">BSE</option>
                            <option value="BAI">BAI</option>
                            <option value="BIT">BIT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-phone">Phone Number</label>
                        <input type="text" id="edit-phone" name="phone_number">
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-image">Profile Image</label>
                        <input type="file" id="edit-image" name="image" accept="image/jpeg,image/png">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
            <p id="delete-confirmation-message">Are you sure you want to delete this user?</p>
            <input type="hidden" id="delete-user-id">
            <input type="hidden" id="delete-user-type">
            <div class="form-actions">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        let allUsers = [];
        let filteredUsers = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;

        // DOM elements
        const editModal = document.getElementById("editModal");
        const deleteModal = document.getElementById("deleteModal");
        const closeBtns = document.querySelectorAll(".close");
        const editForm = document.getElementById("editUserForm");

        // Event listeners
        closeBtns.forEach(btn => {
            btn.onclick = function() {
                if (editModal.style.display === "block") closeModal();
                if (deleteModal.style.display === "block") closeDeleteModal();
            }
        });

        window.onclick = function(event) {
            if (event.target == editModal) closeModal();
            if (event.target == deleteModal) closeDeleteModal();
        };

        editForm.onsubmit = function(e) {
            e.preventDefault();
            updateUser();
        };

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
                document.getElementById("loader").style.display = "block";
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Datacells/core-users`);
                const data = await response.json();
                
                if (data.status === "success") {
                    // Transform the data into a flat array with type information
                    allUsers = [];
                    for (const [type, users] of Object.entries(data.data)) {
                        users.forEach(user => {
                            user.type = type;
                            allUsers.push(user);
                        });
                    }
                    filteredUsers = [...allUsers];
                    renderUsers();
                    updatePagination();
                } else {
                    showAlert("Failed to load users: " + (data.message || "Unknown error"), "error");
                }
            } catch (error) {
                console.error("Error fetching users:", error);
                showAlert("Error fetching users. Please try again.", "error");
            } finally {
                document.getElementById("loader").style.display = "none";
            }
        }

        function filterUsers() {
            const typeFilter = document.getElementById("user-type-filter").value;
            
            if (typeFilter === "All") {
                filteredUsers = [...allUsers];
            } else {
                filteredUsers = allUsers.filter(user => user.type === typeFilter);
            }
            
            currentPage = 1;
            renderUsers();
            updatePagination();
        }

        function resetFilters() {
            document.getElementById("user-type-filter").value = "All";
            filteredUsers = [...allUsers];
            currentPage = 1;
            renderUsers();
            updatePagination();
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById("items-per-page").value);
            currentPage = 1;
            renderUsers();
            updatePagination();
        }

        function renderUsers() {
            const tableBody = document.getElementById("user-table-body");
            tableBody.innerHTML = "";

            if (filteredUsers.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-gray-500">No users found.</td></tr>';
                return;
            }

            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredUsers.length);
            totalPages = Math.ceil(filteredUsers.length / itemsPerPage);

            for (let i = startIndex; i < endIndex; i++) {
                const user = filteredUsers[i];
                
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2">
                            <img src="${user.image || '{{ asset('images/male.png') }}'}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                        </td>
                        <td class="px-4 py-2" data-label="Type">${user.type}</td>
                        <td class="px-4 py-2" data-label="Name">${user.name || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Designation">${user.Designation || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Department">${user.department || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Phone">${user.phone_number || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Actions">
                            <button onclick="openEditModal('${user.id}', '${user.type}')" class="action-btn edit-btn" title="Edit">
                                ✏️
                            </button>
                            <button onclick="openDeleteModal('${user.id}', '${user.type}', '${user.name}')" class="action-btn delete-btn" title="Delete">
                                🗑️
                            </button>
                        </td>
                    </tr>`;
            }
        }

        function updatePagination() {
            document.getElementById("page-info").textContent = `Page ${currentPage} of ${totalPages}`;
            
            document.getElementById("first-page").disabled = currentPage === 1;
            document.getElementById("prev-page").disabled = currentPage === 1;
            document.getElementById("next-page").disabled = currentPage === totalPages || totalPages === 0;
            document.getElementById("last-page").disabled = currentPage === totalPages || totalPages === 0;
        }

        function goToPage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderUsers();
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderUsers();
                updatePagination();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                renderUsers();
                updatePagination();
            }
        }

        function openEditModal(userId, userType) {
            try {
                document.getElementById("edit-user-id").value = userId;
                document.getElementById("edit-user-type").value = userType;
                document.getElementById("edit-modal-title").textContent = `Edit ${userType}`;
                
                // Find the user in our local data
                const user = allUsers.find(u => u.id == userId && u.type === userType);
                
                if (user) {
                    // Populate form fields
                    document.getElementById("edit-name").value = user.name || '';
                    document.getElementById("edit-designation").value = user.Designation || '';
                    document.getElementById("edit-phone").value = user.phone_number || '';
                    
                    // Handle department field for HOD
                    const departmentContainer = document.getElementById("department-container");
                    if (userType === 'HOD') {
                        departmentContainer.style.display = 'block';
                        document.getElementById("edit-department").value = user.department || 'BCS';
                    } else {
                        departmentContainer.style.display = 'none';
                    }
                    
                    editModal.style.display = "block";
                }
            } catch (error) {
                console.error("Error opening edit modal:", error);
                showAlert("Failed to load user details. Please try again.", "error");
            }
        }

        function openDeleteModal(userId, userType, userName) {
            document.getElementById("delete-user-id").value = userId;
            document.getElementById("delete-user-type").value = userType;
            document.getElementById("delete-confirmation-message").textContent = 
                `Are you sure you want to delete ${userType} ${userName}? This action cannot be undone.`;
            deleteModal.style.display = "block";
        }

        function closeModal() {
            editModal.style.display = "none";
            editForm.reset();
        }

        function closeDeleteModal() {
            deleteModal.style.display = "none";
        }

        async function updateUser() {
            const userId = document.getElementById("edit-user-id").value;
            const userType = document.getElementById("edit-user-type").value;
            const formData = new FormData(editForm);
            formData.append('id', userId);
            formData.append('type', userType);
         
            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/update-user-role`, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showAlert(result.message || "User updated successfully!", "success");
                    closeModal();
                    loadUsers(); // Refresh the list
                } else if (result.status === 'error' && result.errors) {
                    // Handle validation errors
                    let errorMessage = "Validation errors:";
                    for (const [field, errors] of Object.entries(result.errors)) {
                        errorMessage += `\n${field}: ${errors.join(', ')}`;
                    }
                    showAlert(errorMessage, "error");
                } else {
                    showAlert(result.message || 'Failed to update user', "error");
                }
            } catch (error) {
                console.error("Error updating user:", error);
                showAlert("Failed to update user. Please try again.", "error");
            }
        }

        async function confirmDelete() {
            const userId = document.getElementById("delete-user-id").value;
            const userType = document.getElementById("delete-user-type").value;
            
            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/delete-user-role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                       
                    },
                    body: JSON.stringify({
                        type: userType,
                        id: userId
                    })
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showAlert(result.message || "User deleted successfully!", "success");
                    closeDeleteModal();
                    loadUsers(); // Refresh the list
                } else {
                    showAlert(result.message || 'Failed to delete user', "error");
                }
            } catch (error) {
                console.error("Error deleting user:", error);
                showAlert("Failed to delete user. Please try again.", "error");
            }
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById("alert-container");
            const alertId = 'alert-' + Date.now();
            
            const alertDiv = document.createElement("div");
            alertDiv.id = alertId;
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `
                <span>${message}</span>
                <span class="alert-close" onclick="document.getElementById('${alertId}').remove()">×</span>
            `;
            
            alertContainer.appendChild(alertDiv);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (document.getElementById(alertId)) {
                    document.getElementById(alertId).remove();
                }
            }, 5000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadUsers();
        });
    </script>
</body>
</html>