<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
    @vite('resources/css/app.css')
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            margin: 0 2px;
        }

        .view-btn {
            background-color: #3b82f6;
            color: white;
        }

        .edit-btn {
            background-color: #f59e0b;
            color: white;
        }
        .top-actions {
            display: flex;
            justify-content: flex-end;
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

        .add-btn {
            background-color: #10b981;
            color: white;
        }

        .bulk-add-btn {
            background-color: #6366f1;
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
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 1.5rem;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        /* Mobile-first table transformation */
        @media (max-width: 768px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
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
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    @include('HOD.partials.profile_panel')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-blue-700">Teacher List</h2>
            <div class="top-actions">
                <button class="add-btn" onclick="window.location.href='{{ route('hod.teachers.add') }}'">
                    📝 Add Teacher
                </button>
                <button class="bulk-add-btn" onclick="window.location.href='{{ route('hod.teachers.add_teacher_excel') }}'">
                    📁 Bulk Upload
                </button>
            </div>
        </div>

        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4">
            <input type="text" id="search-input" class="border p-2 w-full sm:w-96" oninput="searchTeachers()"
                placeholder="Search by Name or CNIC">
            <select id="items-per-page" class="border p-2 w-full sm:w-36" onchange="changeItemsPerPage()">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">
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
                        <th class="px-4 py-2">CNIC (Emp#)</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="teacher-table-body">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

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

    <!-- Edit Teacher Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="text-xl font-bold mb-4">Edit Teacher</h3>
            <form id="editTeacherForm">
                <input type="hidden" id="edit-teacher-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit-cnic">CNIC (Emp#)</label>
                        <input type="text" id="edit-cnic" name="cnic" placeholder="XXXXX-XXXXXXX-X">
                        <div id="cnic-error" class="text-red-500 text-sm hidden"></div>
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit-dob">Date of Birth</label>
                        <input type="date" id="edit-dob" name="date_of_birth">
                    </div>
                    <div class="form-group">
                        <label for="edit-gender">Gender</label>
                        <select id="edit-gender" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-image">Profile Image</label>
                        <input type="file" id="edit-image" name="image" accept="image/jpeg,image/png">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded"
                        onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    @include('components.footer')

    <script>
        let teachers = [];
        let filteredTeachers = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;
        let teacherDetailsBaseRoute =
            "{{ route('hod.teacher.details', ['teacher' => '__PLACEHOLDER__', 'role' => '__ROLE__']) }}";

        // DOM elements
        const editModal = document.getElementById("editModal");
        const closeBtn = document.querySelector(".close");
        const editForm = document.getElementById("editTeacherForm");

        // Event listeners
        closeBtn.onclick = closeModal;
        window.onclick = function(event) {
            if (event.target == editModal) {
                closeModal();
            }
        };

        editForm.onsubmit = function(e) {
            e.preventDefault();
            updateTeacher();
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

        async function loadTeachers() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/teachers`);
                const data = await response.json();
                if (data.Teacher) {
                    teachers = data.Teacher;
                    filteredTeachers = [...teachers];
                    renderTeachers();
                    updatePagination();
                }
            } catch (error) {
                console.error("Error fetching teachers:", error);
                showAlert("Error fetching teachers. Please try again.", "error");
            }
        }

        function searchTeachers() {
            const searchValue = document.getElementById("search-input").value.toLowerCase();
            filteredTeachers = teachers.filter(teacher =>
                teacher.name.toLowerCase().includes(searchValue) ||
                (teacher.cnic && teacher.cnic.toLowerCase().includes(searchValue))
            );
            currentPage = 1;
            renderTeachers();
            updatePagination();
        }

        function resetSearch() {
            document.getElementById("search-input").value = "";
            filteredTeachers = [...teachers];
            currentPage = 1;
            renderTeachers();
            updatePagination();
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById("items-per-page").value);
            currentPage = 1;
            renderTeachers();
            updatePagination();
        }

        function renderTeachers() {
            const tableBody = document.getElementById("teacher-table-body");
            tableBody.innerHTML = "";

            if (filteredTeachers.length === 0) {
                tableBody.innerHTML =
                    '<tr><td colspan="6" class="text-center py-4 text-gray-500">No teachers found.</td></tr>';
                return;
            }

            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredTeachers.length);
            totalPages = Math.ceil(filteredTeachers.length / itemsPerPage);

            for (let i = startIndex; i < endIndex; i++) {
                const teacher = filteredTeachers[i];
                const role = btoa('Teacher');
                const encodedData = btoa(JSON.stringify(teacher));

                const teacherDetailsUrl = teacherDetailsBaseRoute
                    .replace('__PLACEHOLDER__', encodeURIComponent(encodedData))
                    .replace('__ROLE__', encodeURIComponent(role));

                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2">
                            <img src="${teacher.image ? teacher.image : '{{ asset('images/male.png') }}'}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                        </td>
                        <td class="px-4 py-2" data-label="CNIC (Emp#)">${teacher.cnic || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Name">${teacher.name}</td>
                        <td class="px-4 py-2" data-label="Username">${teacher.user.username}</td>
                        <td class="px-4 py-2" data-label="Email">${teacher.user.email}</td>
                        <td class="px-4 py-2" data-label="Actions">
                            <a href="${teacherDetailsUrl}" class="action-btn view-btn" title="View">
                                👁️
                            </a>
                            <button onclick="openEditModal('${teacher.id}')" class="action-btn edit-btn" title="Edit">
                                ✏️
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
                renderTeachers();
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTeachers();
                updatePagination();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                renderTeachers();
                updatePagination();
            }
        }

        async function openEditModal(teacherId) {
            try {
                document.getElementById("edit-teacher-id").value = teacherId;
                document.getElementById("cnic-error").classList.add("hidden");
                editModal.style.display = "block";

                // Find the teacher in our local data
                const teacher = teachers.find(t => t.id == teacherId);

                if (teacher) {
                    document.getElementById("edit-cnic").value = teacher.cnic || '';
                    document.getElementById("edit-name").value = teacher.name || '';
                    document.getElementById("edit-dob").value = teacher.date_of_birth || '';
                    document.getElementById("edit-gender").value = teacher.gender || 'Male';
                }
            } catch (error) {
                console.error("Error opening edit modal:", error);
                showAlert("Failed to load teacher details. Please try again.", "error");
                closeModal();
            }
        }

        function closeModal() {
            editModal.style.display = "none";
            editForm.reset();
            document.getElementById("cnic-error").classList.add("hidden");
        }

        async function updateTeacher() {
            const teacherId = document.getElementById("edit-teacher-id").value;
            const formData = new FormData(editForm);
            formData.append('teacher_id', teacherId);

            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/UpdateTeacher`, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    showAlert(result.message || "Teacher updated successfully!", "success");
                    closeModal();
                    loadTeachers(); // Refresh the list
                } else if (result.status === 'failed' && result.message?.includes('CNIC')) {
                    document.getElementById("cnic-error").textContent = result.message;
                    document.getElementById("cnic-error").classList.remove("hidden");
                } else if (result.status === 'error') {
                    const fullError = result.error || JSON.stringify(result.errors || result.message);
                    showAlert("Server Error: " + fullError, "error");
                } else {
                    showAlert(result.message || 'Failed to update teacher', "error");
                }
            } catch (error) {
                console.error("Fetch error:", error);
                showAlert("Unexpected client-side error: " + error.message, "error");
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
            loadTeachers();
        });
    </script>
</body>

</html>
