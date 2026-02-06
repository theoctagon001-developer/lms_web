<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Re-Enrollment Requests</title>
    @vite('resources/css/app.css')
    <style>
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
        .request-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        .request-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .request-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }
        .request-card .field-value {
            text-align: right;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .request-table {
            min-width: 100%;
            width: auto;
        }
        .status-pending {
            color: #d97706;
            font-weight: 600;
        }
        .btn-accept {
            background-color: #10b981;
            color: white;
        }
        .btn-accept:hover {
            background-color: #059669;
        }
        .btn-reject {
            background-color: #ef4444;
            color: white;
        }
        .btn-reject:hover {
            background-color: #dc2626;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
            font-size: 0.875rem;
        }
        .student-info-cell {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }
        .student-info-row {
            margin-bottom: 2px;
            font-size: 0.875rem;
        }
        .student-info-label {
            font-weight: 600;
            color: #4a5568;
        }
        .course-info-cell {
            display: flex;
            flex-direction: column;
            min-width: 120px;
        }
        .course-info-row {
            margin-bottom: 2px;
            font-size: 0.875rem;
        }
        .course-info-label {
            font-weight: 600;
            color: #4a5568;
        }
        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            .request-card {
                display: block;
            }
        }
        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }
            .request-card {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Course Re-Enrollment Requests</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Search & Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Search by Student Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Student Name</label>
                    <input type="text" id="search-name" class="border rounded-lg p-2 w-full" placeholder="Enter student name" 
                           oninput="searchRequests()">
                </div>

                <!-- Search by RegNo -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Registration No</label>
                    <input type="text" id="search-regno" class="border rounded-lg p-2 w-full" placeholder="Enter registration no" 
                           oninput="searchRequests()">
                </div>

                <!-- Search by Course -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course (Name/Code)</label>
                    <input type="text" id="search-course" class="border rounded-lg p-2 w-full" placeholder="Enter course name or code" 
                           oninput="searchRequests()">
                </div>

                <!-- Semester Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Semester</label>
                    <input type="text" id="search-semester" class="border rounded-lg p-2 w-full" placeholder="Enter semester" 
                           oninput="searchRequests()">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select id="status-filter" class="border rounded-lg p-2 w-full" onchange="searchRequests()">
                        <option value="">All Statuses</option>
                        <option value="Pending">Pending</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
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
                <table class="request-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Basic Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Requested At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="request-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Requests will be loaded here -->
                    </tbody>
                </table>
            </div>
            <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                No requests found matching your criteria.
            </div>
            <div id="loader" class="loader"></div>
        </div>

        <!-- Mobile Card View -->
        <div id="request-card-container">
            <!-- Request cards will be loaded here -->
        </div>
    </div>

    <!-- Action Modal -->
    <div id="action-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" id="modal-title">Process Request</h3>
                <button onclick="closeModal('action-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div id="modal-body">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button onclick="closeModal('action-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button id="confirm-action" class="bg-blue-500 text-white px-4 py-2 rounded-md">Confirm</button>
            </div>
            <div id="modal-loader" class="loader"></div>
            <div id="modal-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let allRequests = [];
        let filteredRequests = [];
        let currentRequestId = null;
        let allSections = [];

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadSections() {
            try {
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                const data = await response.json();
                if (data && Array.isArray(data)) {
                    allSections = data;
                }
            } catch (error) {
                console.error("Error fetching sections:", error);
            }
        }

        async function loadRequests() {
            try {
                document.getElementById('loader').style.display = 'block';
                document.getElementById('request-table-body').innerHTML = '';
                document.getElementById('request-card-container').innerHTML = '';
                document.getElementById('no-results').classList.add('hidden');
                
                API_BASE_URL = await getApiBaseUrl();
                await loadSections();
               
                const response = await fetch(`${API_BASE_URL}api/Insertion/re_enroll/req`);
                const data = await response.json();
                
                if (data && Array.isArray(data)) {
                    allRequests = data;
                    filteredRequests = [...data];
                    renderRequests();
                }
            } catch (error) {
                console.error("Error fetching requests:", error);
                showAlert('error', 'Failed to load requests. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function searchRequests() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const regNoSearch = document.getElementById("search-regno").value.toLowerCase();
            const courseSearch = document.getElementById("search-course").value.toLowerCase();
            const semesterSearch = document.getElementById("search-semester").value.toLowerCase();
            const statusFilter = document.getElementById("status-filter").value;
            
            filteredRequests = allRequests.filter(request => 
                (request.student_name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (request.RegNo.toLowerCase().includes(regNoSearch) || regNoSearch === "") &&
                ((request.course_name.toLowerCase().includes(courseSearch) || 
                  request.course_code.toLowerCase().includes(courseSearch) || 
                  courseSearch === "")) &&
                (request.semester.toLowerCase().includes(semesterSearch) || semesterSearch === "") &&
                (statusFilter === "" || request.status === statusFilter)
            );
            
            renderRequests();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-regno").value = "";
            document.getElementById("search-course").value = "";
            document.getElementById("search-semester").value = "";
            document.getElementById("status-filter").value = "";
            filteredRequests = [...allRequests];
            renderRequests();
        }

        function renderRequests() {
            const tableBody = document.getElementById("request-table-body");
            const cardContainer = document.getElementById("request-card-container");
            tableBody.innerHTML = "";
            cardContainer.innerHTML = "";

            if (filteredRequests.length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }

            filteredRequests.forEach(request => {
                // Add row to desktop table
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="student-info-cell">
                            <div class="flex items-center mb-2">
                                ${request.student_image ? 
                                    `<img src="${request.student_image}" class="h-10 w-10 rounded-full mr-3 object-cover" alt="${request.student_name}">` : 
                                    `<div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                                <div>
                                    <div class="text-sm font-medium text-gray-900">${request.student_name}</div>
                                </div>
                            </div>
                            <div class="student-info-row">
                                <span class="student-info-label">RegNo:</span> ${request.RegNo}
                            </div>
                            <div class="student-info-row">
                                <span class="student-info-label">Program:</span> ${request.program}
                            </div>
                            <div class="student-info-row">
                                <span class="student-info-label">Semester:</span> ${request.semester}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="course-info-cell">
                            <div class="course-info-row">
                                <span class="course-info-label">Code:</span> ${request.course_code}
                            </div>
                            <div class="course-info-row">
                                <span class="course-info-label">Name:</span> ${request.course_name}
                            </div>
                            <div class="course-info-row">
                                <span class="course-info-label">Session:</span> ${request.session}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="${request.reason}">${request.reason}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${request.requested_at}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-${request.status.toLowerCase()}">${request.status}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${request.status === 'Pending' ? `
                            <button onclick="openActionModal(${request.request_id}, 'Accept')" class="btn-accept action-btn">Accept</button>
                            <button onclick="openActionModal(${request.request_id}, 'Reject')" class="btn-reject action-btn">Reject</button>
                        ` : 'No actions'}
                    </td>
                `;
                tableBody.appendChild(row);
                
                // Add card for mobile view
                const card = document.createElement('div');
                card.className = 'request-card';
                card.innerHTML = `
                    <div class="flex items-center mb-3">
                        ${request.student_image ? 
                            `<img src="${request.student_image}" class="h-12 w-12 rounded-full mr-3 object-cover" alt="${request.student_name}">` : 
                            `<div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                        <div>
                            <div class="font-medium text-gray-900">${request.student_name}</div>
                            <div class="text-sm text-gray-500">${request.RegNo}</div>
                            <div class="text-xs text-gray-500">${request.program} - Sem ${request.semester}</div>
                        </div>
                    </div>
                    <div class="field">
                        <span class="field-label">Course:</span>
                        <span class="field-value">
                            ${request.course_code} - ${request.course_name}
                        </span>
                    </div>
                    <div class="field">
                        <span class="field-label">Session:</span>
                        <span class="field-value">${request.session}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Reason:</span>
                        <span class="field-value">${request.reason}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Requested At:</span>
                        <span class="field-value">${request.requested_at}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Status:</span>
                        <span class="field-value status-${request.status.toLowerCase()}">${request.status}</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200 flex justify-end">
                        ${request.status === 'Pending' ? `
                            <button onclick="openActionModal(${request.request_id}, 'Accept')" class="btn-accept action-btn">Accept</button>
                            <button onclick="openActionModal(${request.request_id}, 'Reject')" class="btn-reject action-btn">Reject</button>
                        ` : '<span class="text-gray-500 text-sm">No actions available</span>'}
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }

        async function openActionModal(requestId, action) {
            currentRequestId = requestId;
            const modalTitle = document.getElementById('modal-title');
            const modalBody = document.getElementById('modal-body');
            const confirmBtn = document.getElementById('confirm-action');
            
            if (action === 'Reject') {
                modalTitle.textContent = 'Reject Re-Enrollment Request';
                modalBody.innerHTML = `
                    <p class="mb-4">Are you sure you want to reject this re-enrollment request?</p>
                    <p class="text-sm text-gray-600">This action cannot be undone.</p>
                `;
                confirmBtn.className = 'btn-reject px-4 py-2 rounded-md';
                confirmBtn.textContent = 'Reject';
            } else {
                modalTitle.textContent = 'Accept Re-Enrollment Request';
                
                // Create section dropdown options
                let sectionOptions = '';
                if (allSections.length > 0) {
                    sectionOptions = allSections.map(section => 
                        `<option value="${section.id}">${section.data}</option>`
                    ).join('');
                } else {
                    sectionOptions = '<option value="">Loading sections...</option>';
                    // Try to load sections if not already loaded
                    await loadSections();
                    if (allSections.length > 0) {
                        sectionOptions = allSections.map(section => 
                            `<option value="${section.id}">${section.data}</option>`
                        ).join('');
                    }
                }
                
                modalBody.innerHTML = `
                    <p class="mb-4">Are you sure you want to accept this re-enrollment request?</p>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Select Section</label>
                        <select id="section-select" class="border rounded-lg p-2 w-full">
                            ${sectionOptions}
                        </select>
                    </div>
                `;
                confirmBtn.className = 'btn-accept px-4 py-2 rounded-md';
                confirmBtn.textContent = 'Accept';
            }
            
            document.getElementById('modal-message').classList.add('hidden');
            document.getElementById('action-modal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        async function processRequest() {
            const action = document.getElementById('confirm-action').textContent;
            const status = action === 'Accept' ? 'Accepted' : 'Rejected';
            const sectionId = status === 'Accepted' ? document.getElementById('section-select').value : 0;
            
            if (status === 'Accepted' && !sectionId) {
                showModalMessage('Please select a section', 'error');
                return;
            }
            
            try {
                document.getElementById('modal-loader').style.display = 'block';
                document.getElementById('modal-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/process-request`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        request_id: currentRequestId,
                        status: status,
                        section_id: sectionId
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showModalMessage(data.message || `${status} successfully!`, 'success');
                    // Reload requests after successful action
                    setTimeout(() => {
                        closeModal('action-modal');
                        loadRequests();
                    }, 1500);
                } else {
                    showModalMessage(data.message || `Failed to ${status.toLowerCase()} request.`, 'error');
                }
            } catch (error) {
                console.error('Error processing request:', error);
                showModalMessage('An error occurred while processing the request.', 'error');
            } finally {
                document.getElementById('modal-loader').style.display = 'none';
            }
        }

        function showModalMessage(message, type) {
            const element = document.getElementById('modal-message');
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

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            loadRequests();
            document.getElementById('confirm-action').addEventListener('click', processRequest);
        });
    </script>

    @include('components.footer')
</body>

</html>