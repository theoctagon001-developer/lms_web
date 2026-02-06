<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Profile Management</title>
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .student-card {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .student-card .student-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-card .parent-item {
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .student-card .parent-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .parent-table {
            min-width: 100%;
            width: auto;
        }

        .parent-table tr.parent-row {
            background-color: #f8fafc;
        }

        .parent-table tr.parent-row:hover {
            background-color: #f1f5f9;
        }

        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }

            .mobile-cards {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }

            .mobile-cards {
                display: none;
            }
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            background-color: #e2e8f0;
            color: #1a202c;
        }

        .badge-primary {
            background-color: #4299e1;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Parent Profile Management</h2>

        <!-- Action Buttons -->
        <div class="mb-6 flex justify-end space-x-3">
            <button onclick="openLinkExistingParentModal()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 13a1 1 0 100-2H8a1 1 0 100 2h4zm0-6a1 1 0 100-2H8a1 1 0 100 2h4z"
                        clip-rule="evenodd" />
                </svg>
                Link Existing Parent
            </button>
            <button onclick="openAddParentModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add New Parent
            </button>
        </div>

        <!-- Search & Filters Section -->
        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Search & Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Search by Student Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Student Name</label>
                    <input type="text" id="search-student-name" class="border rounded-lg p-2 w-full"
                        placeholder="Enter student name" oninput="searchParents()">
                </div>

                <!-- Search by Parent Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Parent Name</label>
                    <input type="text" id="search-parent-name" class="border rounded-lg p-2 w-full"
                        placeholder="Enter parent name" oninput="searchParents()">
                </div>

                <!-- Search by Registration Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Registration No</label>
                    <input type="text" id="search-reg-no" class="border rounded-lg p-2 w-full"
                        placeholder="Enter registration no" oninput="searchParents()">
                </div>

                <!-- Section Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Section</label>
                    <input type="text" id="search-section" class="border rounded-lg p-2 w-full"
                        placeholder="Enter section" oninput="searchParents()">
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
                <table class="parent-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reg No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Parents</th>
                        </tr>
                    </thead>
                    <tbody id="parent-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
            <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                No parents found matching your criteria.
            </div>
            <div id="loader" class="loader"></div>
        </div>

        <!-- Mobile Card View -->
        <div id="mobile-cards" class="mobile-cards">
            <!-- Student cards with parents will be loaded here -->
        </div>
    </div>

    <!-- Add Parent Modal -->
    <div id="add-parent-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add New Parent</h3>
                <button onclick="closeModal('add-parent-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Student</label>
                <select id="add-student-id" class="border rounded-lg p-2 w-full">
                    <!-- Students will be loaded here -->
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Parent Name*</label>
                <input type="text" id="add-parent-name" class="border rounded-lg p-2 w-full"
                    placeholder="Enter parent name">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Relation with Student</label>
                <input type="text" id="add-relation" class="border rounded-lg p-2 w-full"
                    placeholder="e.g., Father, Mother, Guardian">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                <input type="text" id="add-contact" class="border rounded-lg p-2 w-full"
                    placeholder="Enter contact number">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                <textarea id="add-address" class="border rounded-lg p-2 w-full" placeholder="Enter address"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('add-parent-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="addParent()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Parent</button>
            </div>
            <div id="add-parent-loader" class="loader"></div>
            <div id="add-parent-message" class="mt-2 text-sm hidden"></div>
            <div id="add-parent-success" class="hidden mt-4 p-3 bg-green-100 text-green-700 rounded">
                <p class="font-medium">Parent added successfully!</p>
                <p id="generated-username" class="mt-1"></p>
                <p id="generated-password" class="mt-1"></p>
                <p class="mt-2 text-sm">Please provide these credentials to the parent.</p>
            </div>
        </div>
    </div>

    <!-- Link Existing Parent Modal -->
    <div id="link-parent-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Link Existing Parent to Student</h3>
                <button onclick="closeModal('link-parent-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Student</label>
                <select id="link-student-id" class="border rounded-lg p-2 w-full">
                    <option value="">Loading students...</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Parent</label>
                <select id="link-parent-id" class="border rounded-lg p-2 w-full">
                    <option value="">Loading parents...</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('link-parent-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="linkExistingParent()" class="bg-green-500 text-white px-4 py-2 rounded-md">Link
                    Parent</button>
            </div>
            <div id="link-parent-loader" class="loader"></div>
            <div id="link-parent-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Edit Parent Modal -->
    <div id="edit-parent-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Parent Details</h3>
                <button onclick="closeModal('edit-parent-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Student</label>
                <input type="text" id="edit-student-name" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Parent Name*</label>
                <input type="text" id="edit-parent-name" class="border rounded-lg p-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Relation with Student</label>
                <input type="text" id="edit-relation" class="border rounded-lg p-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                <input type="text" id="edit-contact" class="border rounded-lg p-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                <textarea id="edit-address" class="border rounded-lg p-2 w-full"></textarea>
            </div>
            <input type="hidden" id="edit-parent-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-parent-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateParent()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save
                    Changes</button>
            </div>
            <div id="edit-parent-loader" class="loader"></div>
            <div id="edit-parent-message" class="mt-2 text-sm hidden"></div>
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
            <input type="hidden" id="email-parent-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('email-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
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
                    <input type="password" id="new-password" class="border rounded-lg p-2 w-full"
                        placeholder="Enter new password">
                    <button class="toggle-password" onclick="togglePasswordVisibility('new-password')">👁️</button>
                </div>
            </div>
            <input type="hidden" id="password-parent-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('password-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updatePassword()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="password-loader" class="loader"></div>
            <div id="password-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Confirm Deletion</h3>
                <button onclick="closeModal('delete-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <p class="text-red-600 font-medium">Are you sure you want to delete this parent profile?</p>
                <p class="mt-2 text-sm text-gray-600">This action will:</p>
                <ul class="list-disc list-inside text-sm text-gray-600 mt-1">
                    <li>Remove the parent from all associated students</li>
                    <li>Delete the parent's user account</li>
                    <li>Revoke all access immediately</li>
                </ul>
                <p class="mt-3 text-sm font-medium">This action cannot be undone.</p>
            </div>
            <input type="hidden" id="delete-parent-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('delete-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
            </div>
            <div id="delete-loader" class="loader"></div>
            <div id="delete-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "http://192.168.0.107:8000/";
        let allParentsData = [];
        let filteredParentsData = [];
        let allStudentsList = [];
        let allParentsList = [];

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadParentsData() {
            try {
                document.getElementById('loader').style.display = 'block';
                document.getElementById('parent-table-body').innerHTML = '';
                document.getElementById('mobile-cards').innerHTML = '';
                document.getElementById('no-results').classList.add('hidden');

                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/parents/view`);
                const data = await response.json();

                if (data.data) {
                    allParentsData = data.data;
                    filteredParentsData = [...allParentsData];
                    renderParentsData();
                    loadStudentDropdown();
                }
            } catch (error) {
                console.error("Error fetching parents data:", error);
                showAlert('error', 'Failed to load parents data. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        async function loadAllStudentsAndParents() {
            try {
                API_BASE_URL = await getApiBaseUrl();

                // Load all students
                const studentsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllStudentData`);
                const studentsData = await studentsResponse.json();
                allStudentsList = studentsData;

                // Load all parents
                const parentsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllParentData`);
                const parentsData = await parentsResponse.json();
                allParentsList = parentsData;

                return true;
            } catch (error) {
                console.error("Error loading dropdown data:", error);
                return false;
            }
        }

        function loadStudentDropdown() {
            const select = document.getElementById('add-student-id');
            select.innerHTML = '';

            // Create a map to track unique students
            const studentsMap = new Map();

            allParentsData.forEach(item => {
                studentsMap.set(item.student_id, {
                    id: item.student_id,
                    name: item.student_name,
                    reg_no: item.reg_no,
                    section: item.section
                });
            });

            // Add options for each unique student
            studentsMap.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = `${student.name} (${student.reg_no}) - ${student.section || 'No Section'}`;
                select.appendChild(option);
            });
        }

        function openLinkExistingParentModal() {
            document.getElementById('link-parent-message').classList.add('hidden');
            document.getElementById('link-parent-modal').style.display = 'flex';

            // Load dropdowns if not already loaded
            if (allStudentsList.length === 0 || allParentsList.length === 0) {
                document.getElementById('link-student-id').innerHTML = '<option value="">Loading students...</option>';
                document.getElementById('link-parent-id').innerHTML = '<option value="">Loading parents...</option>';

                loadAllStudentsAndParents().then(success => {
                    if (success) {
                        populateLinkDropdowns();
                    } else {
                        showMessage('link-parent-message', 'Failed to load student/parent data.', 'error');
                    }
                });
            } else {
                populateLinkDropdowns();
            }
        }

        function populateLinkDropdowns() {
            const studentSelect = document.getElementById('link-student-id');
            const parentSelect = document.getElementById('link-parent-id');

            // Clear existing options
            studentSelect.innerHTML = '';
            parentSelect.innerHTML = '';

            // Add default option
            studentSelect.appendChild(new Option('Select Student', ''));
            parentSelect.appendChild(new Option('Select Parent', ''));

            // Add students
            allStudentsList.forEach(student => {
                studentSelect.appendChild(new Option(student.Format, student.id));
            });

            // Add parents
            allParentsList.forEach(parent => {
                parentSelect.appendChild(new Option(`${parent.name} (${parent.relation}) - ${parent['Address(Contact)']}`, parent.id));
            });
        }

        async function linkExistingParent() {
            const studentId = document.getElementById('link-student-id').value;
            const parentId = document.getElementById('link-parent-id').value;

            if (!studentId || !parentId) {
                showMessage('link-parent-message', 'Please select both student and parent.', 'error');
                return;
            }

            try {
                document.getElementById('link-parent-loader').style.display = 'block';
                document.getElementById('link-parent-message').classList.add('hidden');
                API_BASE_URL = await getApiBaseUrl();

                const response = await fetch(`${API_BASE_URL}api/parents/add/exsisting`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        parent_id: parentId
                    })
                });

                const data = await response.json();

                if (response.status === 201) {
                    showMessage('link-parent-message', 'Parent linked to student successfully!', 'success');
                    // Reload data after a short delay
                    setTimeout(() => {
                        loadParentsData();
                        closeModal('link-parent-modal');
                    }, 1000);
                } else if (response.status === 409) {
                    showMessage('link-parent-message', data.message || 'This parent is already linked to the student.', 'error');
                } else {
                    showMessage('link-parent-message', data.message || 'Failed to link parent to student.', 'error');
                }
            } catch (error) {
                console.error('Error linking parent:', error);

                showMessage('link-parent-message', 'An error occurred while linking parent.', 'error');
            } finally {
                document.getElementById('link-parent-loader').style.display = 'none';
            }
        }

        function searchParents() {
            const studentNameSearch = document.getElementById("search-student-name").value.toLowerCase();
            const parentNameSearch = document.getElementById("search-parent-name").value.toLowerCase();
            const regNoSearch = document.getElementById("search-reg-no").value.toLowerCase();
            const sectionSearch = document.getElementById("search-section").value.toLowerCase();

            filteredParentsData = allParentsData.filter(item =>
                (item.student_name.toLowerCase().includes(studentNameSearch) || studentNameSearch === "") &&
                (item.parents.some(p => p.name.toLowerCase().includes(parentNameSearch)) || parentNameSearch === "") &&
                (item.reg_no.toLowerCase().includes(regNoSearch) || regNoSearch === "") &&
                (item.section ? item.section.toLowerCase().includes(sectionSearch) : true || sectionSearch === "")
            );

            renderParentsData();
        }

        function resetSearch() {
            document.getElementById("search-student-name").value = "";
            document.getElementById("search-parent-name").value = "";
            document.getElementById("search-reg-no").value = "";
            document.getElementById("search-section").value = "";
            filteredParentsData = [...allParentsData];
            renderParentsData();
        }

        function renderParentsData() {
            const tableBody = document.getElementById("parent-table-body");
            const cardContainer = document.getElementById("mobile-cards");
            tableBody.innerHTML = "";
            cardContainer.innerHTML = "";

            if (filteredParentsData.length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }

            filteredParentsData.forEach(item => {
                if (item.parents.length === 0) return;
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">${item.student_name}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.reg_no}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.section || 'N/A'}</td>
                    <td class="px-6 py-4">
                        ${item.parents.map(parent => `
                            <div class="parent-row mb-2 p-3 rounded bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-medium">${parent.name}</span>
                                        <span class="text-sm text-gray-500 ml-2">(${parent.relation || 'No relation specified'})</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="openEditParentModal(${parent.parent_id}, ${item.student_id}, '${escapeHtml(item.student_name)}', '${escapeHtml(parent.name)}', '${escapeHtml(parent.relation || '')}', '${escapeHtml(parent.contact || '')}', '${escapeHtml(parent.address || '')}')" 
        class="text-blue-600 hover:text-blue-800 text-sm">
    Edit
</button>
                                        <button onclick="openDeleteModal(${parent.parent_id}, '${escapeHtml(parent.name)}')" 
                                                class="text-red-600 hover:text-red-800 text-sm">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1 text-sm">
                                    <div>Contact: ${parent.contact || 'N/A'}</div>
                                    <div>Address: ${parent.address || 'N/A'}</div>
                                </div>
                                <div class="mt-2 flex space-x-2">
                                    <button onclick="openEmailModal(${parent.parent_id}, '')" 
                                            class="text-xs bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">
                                        Update Email
                                    </button>
                                    <button onclick="openPasswordModal(${parent.parent_id}, '')" 
                                            class="text-xs bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </td>
                `;
                tableBody.appendChild(row);

                // Mobile Card
                const card = document.createElement('div');
                card.className = 'student-card';
                card.innerHTML = `
                    <div class="student-header">
                        <div>
                            <h4 class="font-bold text-lg">${item.student_name}</h4>
                            <div class="text-sm text-gray-600">${item.reg_no} • ${item.section || 'No Section'}</div>
                        </div>
                    </div>
                    <div class="parents-list">
                        ${item.parents.map(parent => `
                            <div class="parent-item">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-medium">${parent.name}</span>
                                        <span class="text-sm text-gray-500 ml-2">(${parent.relation || 'No relation specified'})</span>
                                    </div>
                                </div>
                                <div class="mt-1 text-sm">
                                    <div>Contact: ${parent.contact || 'N/A'}</div>
                                    <div>Address: ${parent.address || 'N/A'}</div>
                                </div>
                                <div class="parent-actions">
                                  <button onclick="openEditParentModal(${parent.parent_id}, ${item.student_id}, '${escapeHtml(item.student_name)}', '${escapeHtml(parent.name)}', '${escapeHtml(parent.relation || '')}', '${escapeHtml(parent.contact || '')}', '${escapeHtml(parent.address || '')}')" 
        class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
    Edit
</button>
                                    <button onclick="openEmailModal(${parent.parent_id}, '')" 
                                            class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                        Email
                                    </button>
                                    <button onclick="openPasswordModal(${parent.parent_id}, '')" 
                                            class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                        Password
                                    </button>
                                    <button onclick="openDeleteModal(${parent.parent_id}, '${escapeHtml(parent.name)}')" 
                                            class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }

        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return unsafe.toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "\\'")
                .replace(/\n/g, "\\n")
                .replace(/\r/g, "\\r");
        }

        function openAddParentModal() {
            document.getElementById('add-parent-name').value = '';
            document.getElementById('add-relation').value = '';
            document.getElementById('add-contact').value = '';
            document.getElementById('add-address').value = '';
            document.getElementById('add-parent-message').classList.add('hidden');
            document.getElementById('add-parent-success').classList.add('hidden');
            document.getElementById('add-parent-modal').style.display = 'flex';
        }

        function openEditParentModal(parentId, studentId, studentName, parentName, relation, contact, address) {
            document.getElementById('edit-student-name').value = studentName;
            document.getElementById('edit-parent-name').value = parentName;
            document.getElementById('edit-relation').value = relation;
            document.getElementById('edit-contact').value = contact;
            document.getElementById('edit-address').value = address;
            document.getElementById('edit-parent-id').value = parentId;
            document.getElementById('edit-parent-message').classList.add('hidden');
            document.getElementById('edit-parent-modal').style.display = 'flex';
        }

        function openEmailModal(parentId, currentEmail) {
            document.getElementById('current-email').value = currentEmail || 'N/A';
            document.getElementById('new-email').value = currentEmail || '';
            document.getElementById('email-parent-id').value = parentId;
            document.getElementById('email-message').classList.add('hidden');
            document.getElementById('email-modal').style.display = 'flex';
        }

        function openPasswordModal(parentId, username) {
            document.getElementById('password-username').value = username || 'N/A';
            document.getElementById('new-password').value = '';
            document.getElementById('password-parent-id').value = parentId;
            document.getElementById('password-message').classList.add('hidden');
            document.getElementById('password-modal').style.display = 'flex';
        }

        function openDeleteModal(parentId, parentName) {
            document.getElementById('delete-parent-id').value = parentId;
            document.getElementById('delete-message').textContent = `Delete parent: ${parentName}`;
            document.getElementById('delete-message').classList.add('hidden');
            document.getElementById('delete-modal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }

        async function addParent() {
            const studentId = document.getElementById('add-student-id').value;
            const name = document.getElementById('add-parent-name').value.trim();
            const relation = document.getElementById('add-relation').value.trim();
            const contact = document.getElementById('add-contact').value.trim();
            const address = document.getElementById('add-address').value.trim();

            if (!name) {
                showMessage('add-parent-message', 'Parent name is required.', 'error');
                return;
            }

            try {
                document.getElementById('add-parent-loader').style.display = 'block';
                document.getElementById('add-parent-message').classList.add('hidden');

                const response = await fetch(`${API_BASE_URL}api/parents/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        name: name,
                        relation_with_student: relation,
                        contact: contact,
                        address: address
                    })
                });

                const data = await response.json();

                if (data.message === 'Parent created successfully.') {
                    // Show success message with credentials
                    document.getElementById('add-parent-success').classList.remove('hidden');
                    document.getElementById('generated-username').textContent = `Username: ${data.username}`;
                    document.getElementById('generated-password').textContent = `Password: ${data.password}`;

                    // Reload data after a short delay
                    setTimeout(() => {
                        loadParentsData();
                        closeModal('add-parent-modal');
                    }, 3000);
                } else {
                    showMessage('add-parent-message', data.message || 'Failed to add parent.', 'error');
                }
            } catch (error) {
                console.error('Error adding parent:', error);
                showMessage('add-parent-message', 'An error occurred while adding parent.', 'error');
            } finally {
                document.getElementById('add-parent-loader').style.display = 'none';
            }
        }

        async function updateParent() {
            const parentId = document.getElementById('edit-parent-id').value;
            const name = document.getElementById('edit-parent-name').value.trim();
            const relation = document.getElementById('edit-relation').value.trim();
            const contact = document.getElementById('edit-contact').value.trim();
            const address = document.getElementById('edit-address').value.trim();

            if (!name) {
                showMessage('edit-parent-message', 'Parent name is required.', 'error');
                return;
            }

            try {
                document.getElementById('edit-parent-loader').style.display = 'block';
                document.getElementById('edit-parent-message').classList.add('hidden');

                const response = await fetch(`${API_BASE_URL}api/parents/update/${parentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: name,
                        relation_with_student: relation,
                        contact: contact,
                        address: address
                    })
                });

                const data = await response.json();

                if (data.message === 'Parent updated successfully.') {
                    showMessage('edit-parent-message', 'Parent updated successfully!', 'success');
                    // Reload data after a short delay
                    setTimeout(() => {
                        loadParentsData();
                        closeModal('edit-parent-modal');
                    }, 1000);
                } else {
                    showMessage('edit-parent-message', data.message || 'Failed to update parent.', 'error');
                }
            } catch (error) {
                console.error('Error updating parent:', error);
                showMessage('edit-parent-message', 'An error occurred while updating parent.', 'error');
            } finally {
                document.getElementById('edit-parent-loader').style.display = 'none';
            }
        }

        async function updateEmail() {
            const parentId = document.getElementById('email-parent-id').value;
            const newEmail = document.getElementById('new-email').value.trim();

            if (!newEmail) {
                showMessage('email-message', 'Please enter a valid email address.', 'error');
                return;
            }

            try {
                document.getElementById('email-loader').style.display = 'block';
                document.getElementById('email-message').classList.add('hidden');

                const response = await fetch(`${API_BASE_URL}api/parents/update-email/${parentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: newEmail
                    })
                });

                const data = await response.json();

                if (data.message === 'Email updated successfully.') {
                    showMessage('email-message', 'Email updated successfully!', 'success');
                    // Reload data after a short delay
                    setTimeout(() => {
                        loadParentsData();
                        closeModal('email-modal');
                    }, 1000);
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
            const parentId = document.getElementById('password-parent-id').value;
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

                const response = await fetch(`${API_BASE_URL}api/parents/update-password/${parentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        password: newPassword
                    })
                });

                const data = await response.json();

                if (data.message === 'Password updated successfully.') {
                    showMessage('password-message', 'Password updated successfully!', 'success');
                    // Close modal after 1 second
                    setTimeout(() => closeModal('password-modal'), 1000);
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

        async function confirmDelete() {
            const parentId = document.getElementById('delete-parent-id').value;

            try {
                document.getElementById('delete-loader').style.display = 'block';
                document.getElementById('delete-message').classList.add('hidden');

                const response = await fetch(`${API_BASE_URL}api/parents/remove/${parentId}`, {
                    method: 'DELETE'
                });

                const data = await response.json();

                if (data.message === 'Parent and associated user deleted successfully.') {
                    showMessage('delete-message', 'Parent deleted successfully!', 'success');
                    setTimeout(() => {
                        loadParentsData();
                        closeModal('delete-modal');
                    }, 1000);
                } else {
                    showMessage('delete-message', data.message || 'Failed to delete parent.', 'error');
                }
            } catch (error) {
                console.error('Error deleting parent:', error);
                showMessage('delete-message', 'An error occurred while deleting parent.', 'error');
            } finally {
                document.getElementById('delete-loader').style.display = 'none';
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

        document.addEventListener("DOMContentLoaded", loadParentsData);
    </script>

    @include('components.footer')
</body>

</html>