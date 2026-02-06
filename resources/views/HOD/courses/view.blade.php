{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
          .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            margin: 0 2px;
        }
        /* Base styles */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3b82f6;
            /* Blue-500 */
            color: white;
        }

        tr:hover {
            background-color: #f9fafb;
            /* Gray-50 */
        }

        /* Mobile-first responsive styles */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: hidden;
                /* Prevent horizontal scrolling */
            }

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
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                background-color: white;
            }

            td {
                border: none;
                position: relative;
                padding-left: 50% !important;
                text-align: left !important;
                min-height: 45px;
                display: flex;
                align-items: center;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                color: #333;
            }

            /* Special handling for action buttons */
            td:last-child {
                padding: 0.75rem !important;
                display: flex;
                justify-content: center;
            }

            td:last-child:before {
                display: none;
            }

            td:last-child button {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }

            /* Search container adjustments */
            .search-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .search-container input,
            .search-container button {
                width: 100%;
            }
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

        /* Top action buttons */
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

    </style>
    <script>
        let courses = [];
        let filteredCourses = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        async function loadCourses() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/courses`);
                const data = await response.json();
                if (data.Courses) {
                    courses = data.Courses;
                    filteredCourses = [...courses];
                    renderCourses();
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        }

        function searchCourses() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const codeSearch = document.getElementById("search-code").value.toLowerCase();

            filteredCourses = courses.filter(course =>
                (course.name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (course.code.toLowerCase().includes(codeSearch) || codeSearch === "")
            );

            renderCourses();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-code").value = "";
            filteredCourses = [...courses];
            renderCourses();
        }

        function renderCourses() {
            const tableBody = document.getElementById("course-table-body");
            tableBody.innerHTML = "";

            if (filteredCourses.length === 0) {
                tableBody.innerHTML =
                    '<tr><td colspan="7" class="text-center py-4 text-gray-500">No courses found.</td></tr>';
                return;
            }

            filteredCourses.forEach(course => {
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2" data-label="Code">${course.code}</td>
                        <td class="px-4 py-2" data-label="Name">${course.name}</td>
                        <td class="px-4 py-2" data-label="Credit Hours">${course.credit_hours}</td>
                        <td class="px-4 py-2" data-label="Pre-Req">${course.pre_req_main}</td>
                        <td class="px-4 py-2" data-label="Lab">${course.lab == 1 ? 'Lab' : 'No Lab'}</td>
                        <td class="px-4 py-2" data-label="Short Form">${course.description}</td>
                        
                    </tr>`;
            });
        }
      
        document.addEventListener("DOMContentLoaded", loadCourses);
    </script>
</head>

<body class="bg-gray-100">

    @include('HOD.partials.profile_panel')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-blue-700">Course List</h2>
            <div class="top-actions">
                <button class="add-btn" onclick="window.location.href='{{ route('hod.courses.add') }}'">
                    📝 Add Course
                </button>
                <button class="bulk-add-btn"
                    onclick="window.location.href='{{ route('hod.courses.add_course_excel') }}'">
                    📁 Bulk Upload
                </button>
            </div>
        </div>
        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4 search-container">
            <input type="text" id="search-name" class="border p-2 w-full sm:w-96" oninput="searchCourses()"
                placeholder="Search by Course Name">
            <input type="text" id="search-code" class="border p-2 w-full sm:w-96" oninput="searchCourses()"
                placeholder="Search by Course Code">
            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">Refresh</button>
        </div>

        <div class="table-container mx-auto max-w-5xl">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Code</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Credit Hours</th>
                        <th class="px-4 py-2">Pre-Req</th>
                        <th class="px-4 py-2">Lab</th>
                        <th class="px-4 py-2">Short Form</th>
                       
                    </tr>
                </thead>
                <tbody id="course-table-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('components.loader')
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    @vite('resources/css/app.css')
    <style>
        .filter-block {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .filter-title {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .search-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .search-group {
            flex: 1;
            min-width: 150px;
        }
        
        .search-group label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.8rem;
            color: #64748b;
        }
        
        .search-group input,
        .search-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }
        
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            cursor: pointer;
            border-radius: 0.25rem;
            font-size: 0.85rem;
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
            font-size: 0.85rem;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Course Table Styles */
        .course-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .course-table thead th {
            padding: 0.75rem 1rem;
            text-align: left;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .course-table tbody td {
            padding: 1rem;
            vertical-align: top;
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-deleted {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .type-core {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .type-elective {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .lab-yes {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .lab-no {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-btn {
            padding: 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            transition: all 0.2s;
            min-width: 80px;
        }
        
        .view-btn {
            background-color: #3b82f6;
            color: white;
        }
        
        .edit-btn {
            background-color: #f59e0b;
            color: white;
        }
        
        .delete-btn {
            background-color: #ef4444;
            color: white;
        }
        
        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Top action buttons */
        .top-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .top-actions button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            font-size: 0.85rem;
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
        
        /* Toast notifications */
        .toast {
            animation: slide-in 0.3s ease-out;
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 100;
            max-width: 350px;
        }
        
        .toast-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .toast-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }
        
        .toast-warning {
            background-color: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        
        /* Mobile styles */
        @media (max-width: 768px) {
            .course-table thead {
                display: none;
            }
            
            .course-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .course-table tbody td {
                display: block;
                padding: 0.75rem;
                text-align: right;
            }
            
            .course-table tbody td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 0.75rem;
                color: #64748b;
            }
            
            .action-buttons {
                justify-content: flex-end;
            }
            
            .search-container {
                flex-direction: column;
            }
            
            .search-group {
                min-width: 100%;
            }
            
            .filter-block {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('HOD.partials.profile_panel')

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h2 class="text-2xl font-bold text-blue-700">Course List</h2>
            <div class="top-actions">
                <button class="add-btn" onclick="window.location.href='{{ route('hod.courses.add') }}'">
                    ➕ Add Course
                </button>
                <button class="bulk-add-btn" onclick="window.location.href='{{ route('hod.courses.add_course_excel') }}'">
                    📁 Bulk Upload
                </button>
            </div>
        </div>

        <!-- Search Filters -->
        <div class="filter-block">
            <div class="filter-title">Basic Filters</div>
            <div class="search-container">
                <div class="search-group">
                    <label for="search-name">Course Name</label>
                    <input type="text" id="search-name" oninput="searchCourses()" placeholder="Search by name">
                </div>
                <div class="search-group">
                    <label for="search-code">Course Code</label>
                    <input type="text" id="search-code" oninput="searchCourses()" placeholder="Search by code">
                </div>
                <div class="search-group">
                    <label for="search-program">Program</label>
                    <select id="search-program" onchange="searchCourses()">
                        <option value="">All Programs</option>
                        <option value="BCS">BCS</option>
                        <option value="BAI">BAI</option>
                        <option value="BSE">BSE</option>
                        <option value="BIT">BIT</option>
                        <option value="General Purpose">General Purpose</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Advanced Filters -->
        <div class="filter-block">
            <div class="filter-title">Advanced Filters</div>
            <div class="search-container">
                <div class="search-group">
                    <label for="search-credit-hours">Credit Hours</label>
                    <select id="search-credit-hours" onchange="searchCourses()">
                        <option value="">All</option>
                        <option value="1">1 Credit</option>
                        <option value="2">2 Credits</option>
                        <option value="3">3 Credits</option>
                        <option value="4">4 Credits</option>
                    </select>
                </div>
                <div class="search-group">
                    <label for="search-type">Course Type</label>
                    <select id="search-type" onchange="searchCourses()">
                        <option value="">All Types</option>
                        <option value="Core">Core</option>
                        <option value="Elective">Elective</option>
                    </select>
                </div>
                <div class="search-group">
                    <label for="search-lab">Lab</label>
                    <select id="search-lab" onchange="searchCourses()">
                        <option value="">All</option>
                        <option value="1">With Lab</option>
                        <option value="0">Without Lab</option>
                    </select>
                </div>
                <div class="search-group">
                    <label for="search-status">Status</label>
                    <select id="search-status" onchange="searchCourses()">
                        <option value="">All</option>
                        <option value="0">Active</option>
                        <option value="1">Deleted</option>
                    </select>
                </div>
                <div class="search-group" style="align-self: flex-end;">
                    <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded w-full">
                        🔄 Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Table -->
        <div class="table-container rounded-lg shadow overflow-hidden">
            <table class="course-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Program</th>
                        <th>Type</th>
                        <th>Credits</th>
                        <th>Lab</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="course-table-body">
                    <tr><td colspan="8" class="text-center py-4 text-gray-500">Loading...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <button id="first-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                «
            </button>
            <button id="prev-page" class="pagination-btn" onclick="prevPage()" disabled>
                ‹
            </button>
            <span id="page-info" class="px-2 text-sm">Page 1 of 1</span>
            <button id="next-page" class="pagination-btn" onclick="nextPage()" disabled>
                ›
            </button>
            <button id="last-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                »
            </button>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h3 class="text-xl font-bold mb-4">Edit Course</h3>
            <form id="editCourseForm">
                <input type="hidden" id="edit-course-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit-code">Course Code</label>
                        <input type="text" id="edit-code" name="code" required maxlength="20">
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Course Name</label>
                        <input type="text" id="edit-name" name="name" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="edit-credit-hours">Credit Hours</label>
                        <select id="edit-credit-hours" name="credit_hours" required>
                            <option value="">Select Credit Hours</option>
                            <option value="1">1 Credit Hour</option>
                            <option value="2">2 Credit Hours</option>
                            <option value="3">3 Credit Hours</option>
                            <option value="4">4 Credit Hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-program-name">Program</label>
                        <select id="edit-program-name" name="program_name" required>
                            <option value="">Select Program</option>
                            <option value="BCS">BCS</option>
                            <option value="BAI">BAI</option>
                            <option value="BSE">BSE</option>
                            <option value="BIT">BIT</option>
                            <option value="General Purpose">General Purpose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-type">Course Type</label>
                        <select id="edit-type" name="type">
                            <option value="Core">Core</option>
                            <option value="Elective">Elective</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lab Required</label>
                        <div class="mt-1 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="lab" value="1" required checked class="h-4 w-4 text-blue-600">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="lab" value="0" class="h-4 w-4 text-blue-600">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-pre-req-code">Prerequisite Course Code</label>
                        <input type="text" id="edit-pre-req-code" name="pre_req_code" maxlength="20">
                        <p class="text-xs text-gray-500 mt-1">Leave blank if no prerequisite</p>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-description">Short Form</label>
                        <input type="text" id="edit-description" name="description" maxlength="10">
                        <p class="text-xs text-gray-500 mt-1">Short abbreviation (max 10 chars)</p>
                    </div>
                    <div class="form-group">
                        <label for="edit-is-deleted">Status</label>
                        <select id="edit-is-deleted" name="is_deleted">
                            <option value="0">Active</option>
                            <option value="1">Deleted</option>
                        </select>
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
            <span class="close" onclick="closeDeleteModal()">×</span>
            <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
            <p class="mb-6">Are you sure you want to mark this course as deleted?</p>
            <input type="hidden" id="delete-course-id">
            <div class="form-actions">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <span class="text-gray-700 font-medium">Processing...</span>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container"></div>

    @include('components.loader')

    <script>
        let courses = [];
        let filteredCourses = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;

        // DOM elements
        const editModal = document.getElementById("editModal");
        const deleteModal = document.getElementById("deleteModal");
        const closeBtns = document.querySelectorAll(".close");
        const editForm = document.getElementById("editCourseForm");
        const loadingOverlay = document.getElementById("loading-overlay");
        const toastContainer = document.getElementById("toast-container");

        // Event listeners
        closeBtns.forEach(btn => {
            if(btn.parentElement.id === "editModal") {
                btn.onclick = closeEditModal;
            } else if(btn.parentElement.id === "deleteModal") {
                btn.onclick = closeDeleteModal;
            }
        });
        
        window.onclick = function(event) {
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == deleteModal) {
                closeDeleteModal();
            }
        };

        editForm.onsubmit = function(e) {
            e.preventDefault();
            updateCourse();
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

        async function loadCourses() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/courses`);
                const data = await response.json();
                if (data.Courses) {
                    courses = data.Courses;
                    filteredCourses = [...courses];
                    renderCourses();
                    updatePagination();
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
                showToast("Failed to load courses. Please try again.", "error");
            }
        }

        function searchCourses() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const codeSearch = document.getElementById("search-code").value.toLowerCase();
            const programSearch = document.getElementById("search-program").value;
            const creditSearch = document.getElementById("search-credit-hours").value;
            const typeSearch = document.getElementById("search-type").value;
            const labSearch = document.getElementById("search-lab").value;
            const statusSearch = document.getElementById("search-status").value;

            filteredCourses = courses.filter(course => {
                const matchName = course.name.toLowerCase().includes(nameSearch) || nameSearch === "";
                const matchCode = course.code.toLowerCase().includes(codeSearch) || codeSearch === "";
                const matchProgram = course.program_id === programSearch || programSearch === "";
                const matchCredit = course.credit_hours == creditSearch || creditSearch === "";
                const matchType = course.type === typeSearch || typeSearch === "";
                const matchLab = labSearch === "" || (course.lab == (labSearch === "1"));
                const matchStatus = statusSearch === "" || (course.is_deleted == statusSearch);

                return matchName && matchCode && matchProgram && matchCredit && matchType && matchLab && matchStatus;
            });

            currentPage = 1;
            renderCourses();
            updatePagination();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-code").value = "";
            document.getElementById("search-program").value = "";
            document.getElementById("search-credit-hours").value = "";
            document.getElementById("search-type").value = "";
            document.getElementById("search-lab").value = "";
            document.getElementById("search-status").value = "";
            filteredCourses = [...courses];
            currentPage = 1;
            renderCourses();
            updatePagination();
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById("items-per-page").value);
            currentPage = 1;
            renderCourses();
            updatePagination();
        }

        function renderCourses() {
            const tableBody = document.getElementById("course-table-body");
            tableBody.innerHTML = "";

            if (filteredCourses.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-gray-500">No courses found.</td></tr>';
                return;
            }

            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredCourses.length);
            totalPages = Math.ceil(filteredCourses.length / itemsPerPage);

            for (let i = startIndex; i < endIndex; i++) {
                const course = filteredCourses[i];
                
                tableBody.innerHTML += `
                    <tr>
                        <td data-label="Code">${course.code}</td>
                        <td data-label="Name">${course.name}</td>
                        <td data-label="Program">${course.program_id}</td>
                        <td data-label="Type"><span class="status-badge ${course.type === 'Core' ? 'type-core' : 'type-elective'}">${course.type}</span></td>
                        <td data-label="Credits">${course.credit_hours}</td>
                        <td data-label="Lab"><span class="status-badge ${course.lab == 1 ? 'lab-yes' : 'lab-no'}">${course.lab == 1 ? 'Yes' : 'No'}</span></td>
                        <td data-label="Status"><span class="status-badge ${course.is_deleted == 1 ? 'status-deleted' : 'status-active'}">${course.is_deleted == 1 ? 'Deleted' : 'Active'}</span></td>
                        <td data-label="Actions">
                            <div class="action-buttons">
                                <button onclick="openEditModal('${course.id}')" class="action-btn edit-btn">
                                    ✏️ Edit
                                </button>
                                <button onclick="openDeleteModal('${course.id}')" class="action-btn delete-btn">
                                    🗑️ Delete
                                </button>
                            </div>
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
                renderCourses();
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderCourses();
                updatePagination();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                renderCourses();
                updatePagination();
            }
        }

        function openEditModal(courseId) {
            const course = courses.find(c => c.id == courseId);
            if (!course) return;

            // Populate form fields
            document.getElementById("edit-course-id").value = course.id;
            document.getElementById("edit-code").value = course.code || '';
            document.getElementById("edit-name").value = course.name || '';
            document.getElementById("edit-credit-hours").value = course.credit_hours || '';
            document.getElementById("edit-program-name").value = course.program_id || '';
            document.getElementById("edit-type").value = course.type || 'Core';
            document.getElementById("edit-description").value = course.description || '';
            document.getElementById("edit-is-deleted").value = course.is_deleted || '0';
            
            // Set lab radio button
            const labYes = document.querySelector('input[name="lab"][value="1"]');
            const labNo = document.querySelector('input[name="lab"][value="0"]');
            if (course.lab == 1) {
                labYes.checked = true;
            } else {
                labNo.checked = true;
            }
            
            // Set prerequisite if exists
            if (course.pre_req_main && course.pre_req_main !== 'Main') {
                const prereqCourse = courses.find(c => c.id == course.pre_req_main);
                if (prereqCourse) {
                    document.getElementById("edit-pre-req-code").value = prereqCourse.code || '';
                }
            } else {
                document.getElementById("edit-pre-req-code").value = '';
            }

            editModal.style.display = "block";
        }

        function closeEditModal() {
            editModal.style.display = "none";
            editForm.reset();
        }

        function openDeleteModal(courseId) {
            document.getElementById("delete-course-id").value = courseId;
            deleteModal.style.display = "block";
        }

        function closeDeleteModal() {
            deleteModal.style.display = "none";
        }

        async function updateCourse() {
            const courseId = document.getElementById("edit-course-id").value;
            const formData = new FormData(editForm);
            const formObject = Object.fromEntries(formData.entries());
            
            // Convert lab value to boolean
            formObject.lab = formObject.lab === '1';
            formObject.is_deleted = formObject.is_deleted === '1';
            formObject.course_id = courseId;

            showLoading();

            try {
                const response = await fetch(`${API_BASE_URL}api/Hod/update-course`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        
                    },
                    body: JSON.stringify(formObject)
                });

                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        showToast('Validation failed. Please check the form.', 'error');
                    } else {
                        showToast(result.message || 'Failed to update course', 'error');
                    }
                    return;
                }

                showToast('Course updated successfully!', 'success');
                closeEditModal();
                loadCourses(); // Refresh the list

            } catch (error) {
                console.error("Error updating course:", error);
                showToast("Failed to update course. Please try again.", "error");
            } finally {
                hideLoading();
            }
        }

        async function confirmDelete() {
            const courseId = document.getElementById("delete-course-id").value;
            
            showLoading();

            try {
                const response = await fetch(`${API_BASE_URL}api/Hod/course/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                      
                    },
                    body: JSON.stringify({ course_id: courseId })
                });

                const result = await response.json();

                if (!response.ok) {
                    showToast(result.message || 'Failed to delete course', 'error');
                    return;
                }

                showToast('Course marked as deleted successfully!', 'success');
                closeDeleteModal();
                loadCourses(); // Refresh the list

            } catch (error) {
                console.error("Error deleting course:", error);
                showToast("Failed to delete course. Please try again.", "error");
            } finally {
                hideLoading();
            }
        }

        function showLoading() {
            loadingOverlay.style.display = "flex";
        }

        function hideLoading() {
            loadingOverlay.style.display = "none";
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type} p-4 mb-2 rounded shadow-lg`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <div class="mr-3">
                        ${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}
                    </div>
                    <div class="flex-1">
                        ${message}
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-lg">×</button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadCourses();
            
            // Set CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        });
    </script>
</body>
</html>