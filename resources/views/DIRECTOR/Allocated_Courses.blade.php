<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocated Courses</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --secondary: #64748b;
            --light: #f8fafc;
            --dark: #1e293b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sticky-top-container {
            background-color: white;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 100%;
            margin: 0 auto;
        }

        .sticky-top-bar h1 {
            font-weight: 600;
            color: var(--primary);
            cursor: pointer;
            transition: color 0.2s;
        }

        .sticky-top-bar h1:hover {
            color: var(--primary-dark);
        }

        .main-container {
            flex: 1;
            padding: 2rem 1rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .filter-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-title i {
            color: var(--primary);
        }

        .search-input {
            transition: all 0.2s ease;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            width: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: white;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: #f5f7ff;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            padding: 1rem;
            text-align: left;
            position: sticky;
            top: 0;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            background-color: white;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #e0e7ff;
            color: var(--primary);
        }

        .footer {
            background-color: white;
            padding: 1.5rem 0;
            margin-top: auto;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            text-align: center;
            color: var(--secondary);
            font-size: 0.875rem;
        }

        /* Modal styles */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            max-height: 90vh;
            scrollbar-width: thin;
            background: white;
            border-radius: 0.75rem;
            width: 95%;
            max-width: 400px;
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .filter-card {
                padding: 1rem;
            }

            .table th {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--border);
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid var(--border);
            }

            .table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--secondary);
                margin-right: 1rem;
            }

            .table td:last-child {
                border-bottom: none;
                justify-content: center;
            }

            .table td:last-child:before {
                display: none;
            }
        }
    </style>
</head>
<body>
 <div class="sticky-top-container">
    <div class="sticky-top-bar">
        <div class="flex items-center">
            <a href="{{ route('director.dashboard') }}" class="text-xl font-bold text-blue-600">
                Director <span class="hidden sm:inline"></span>
            </a>
        </div>
        @include('DIRECTOR.Profile')
    </div>
</div>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Allocated Courses</h1>
            <p class="page-subtitle">View and manage course allocations for current and previous sessions</p>
        </div>

        <!-- Filters Section -->
        <div class="card filter-card">
            <h2 class="filter-title">
                <i class="fas fa-filter"></i> Filters
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="sessionFilter" class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                    <select id="sessionFilter" class="search-input" onchange="filterData()">
                        <option value="">All Sessions</option>
                    </select>
                </div>
                <div>
                    <label for="sectionFilter" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <input type="text" id="sectionFilter" class="search-input" placeholder="Filter by Section" onkeyup="filterData()">
                </div>
                <div>
                    <label for="courseCodeFilter" class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                    <input type="text" id="courseCodeFilter" class="search-input" placeholder="Filter by Course Code" onkeyup="filterData()">
                </div>
                <div>
                    <label for="courseNameFilter" class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                    <input type="text" id="courseNameFilter" class="search-input" placeholder="Filter by Course Name" onkeyup="filterData()">
                </div>
                <div>
                    <label for="teacherFilter" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                    <input type="text" id="teacherFilter" class="search-input" placeholder="Filter by Teacher" onkeyup="filterData()">
                </div>
                <div>
                    <label for="juniorFilter" class="block text-sm font-medium text-gray-700 mb-1">Junior Lecturer</label>
                    <input type="text" id="juniorFilter" class="search-input" placeholder="Filter by Junior Lecturer" onkeyup="filterData()">
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="resetFilters()" class="btn btn-outline">
                    <i class="fas fa-sync-alt"></i> Reset Filters
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Teacher</th>
                            <th class="hidden md:table-cell">Junior Lecturer</th>
                            <th class="hidden lg:table-cell">Session</th>
                            <th>Section</th>
                            <th class="hidden lg:table-cell">Enrollments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="courseTableBody">
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Loading course data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Detail Modal -->
    <div id="mobileDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="modal-overlay absolute inset-0"></div>
        <div class="modal-content relative z-10">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-900">Course Details</h3>
                <button onclick="closeMobileDetail()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="mobileDetailContent" class="modal-body space-y-4">
                <!-- Content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button onclick="closeMobileDetail()" class="btn btn-outline">Close</button>
                <button id="modalViewButton" class="btn btn-primary">View Full Details</button>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            © Sharjeel | Ali | Sameer Learning Management System
        </div>
    </footer>

    <script>
        let courses = [];
        let API_BASE_URL = "http://127.0.0.1:8000/";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadAllocations() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/getCourseAllocation`);
                const result = await response.json();
                
                if (response.ok) {
                    courses = result.data;
                    populateFilters();
                    renderTable(result.data);
                } else {
                    showError("Failed to load course data. Please try again.");
                }
            } catch (error) {
                console.error("Error fetching data:", error);
                showError("Network error. Please check your connection.");
            }
        }

        function showError(message) {
            const tableBody = document.getElementById("courseTableBody");
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-6 text-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i> ${message}
                    </td>
                </tr>`;
        }

        function populateFilters() {
            const sessionFilter = document.getElementById("sessionFilter");
            const uniqueSessions = [...new Set(courses.map(c => c.SessionName))].sort();
            
            uniqueSessions.forEach(session => {
                const option = document.createElement("option");
                option.value = session;
                option.textContent = session;
                sessionFilter.appendChild(option);
            });
        }

        function renderTable(data) {
            const tableBody = document.getElementById("courseTableBody");
            tableBody.innerHTML = "";
            
            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            <i class="fas fa-search mr-2"></i> No courses match your filters
                        </td>
                    </tr>`;
                return;
            }
            
            data.forEach(course => {
                const encodedData = btoa(JSON.stringify(course));
                const studentDetailsUrl = `{{ route('Director.course.details', ['course' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', encodedData);
                
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td data-label="Course Code">${course.CourseCode}</td>
                    <td data-label="Course Name">
                        <div class="font-medium">${course.CourseName}</div>
                        <div class="text-sm text-gray-500 md:hidden mt-1">${course.CourseCode}</div>
                    </td>
                    <td data-label="Teacher">${course.Teacher}</td>
                    <td class="hidden md:table-cell" data-label="Junior Lecturer">${course.JuniorLecturer || '-'}</td>
                    <td class="hidden lg:table-cell" data-label="Session">${course.SessionName}</td>
                    <td data-label="Section">
                        <span class="badge">${course.Section_name}</span>
                    </td>
                    <td class="hidden lg:table-cell" data-label="Enrollments">
                        <span class="badge">${course.total_enrollments}</span>
                    </td>
                    <td data-label="Action">
                        <div class="flex justify-center">
                            <a href="${studentDetailsUrl}" class="btn btn-primary px-3 py-1 text-sm">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        }

        function filterData() {
            const sessionFilter = document.getElementById("sessionFilter").value.toLowerCase();
            const sectionFilter = document.getElementById("sectionFilter").value.toLowerCase();
            const courseCodeFilter = document.getElementById("courseCodeFilter").value.toLowerCase();
            const courseNameFilter = document.getElementById("courseNameFilter").value.toLowerCase();
            const teacherFilter = document.getElementById("teacherFilter").value.toLowerCase();
            const juniorFilter = document.getElementById("juniorFilter").value.toLowerCase();
            
            const filteredData = courses.filter(course => {
                return (
                    (sessionFilter === "" || course.SessionName.toLowerCase().includes(sessionFilter)) &&
                    (sectionFilter === "" || course.Section_name.toLowerCase().includes(sectionFilter)) &&
                    (courseCodeFilter === "" || course.CourseCode.toLowerCase().includes(courseCodeFilter)) &&
                    (courseNameFilter === "" || course.CourseName.toLowerCase().includes(courseNameFilter)) &&
                    (teacherFilter === "" || course.Teacher.toLowerCase().includes(teacherFilter)) &&
                    (juniorFilter === "" || (course.JuniorLecturer && course.JuniorLecturer.toLowerCase().includes(juniorFilter)))
                );
            });
            
            renderTable(filteredData);
        }

        function resetFilters() {
            document.getElementById("sessionFilter").value = "";
            document.getElementById("sectionFilter").value = "";
            document.getElementById("courseCodeFilter").value = "";
            document.getElementById("courseNameFilter").value = "";
            document.getElementById("teacherFilter").value = "";
            document.getElementById("juniorFilter").value = "";
            filterData();
        }

        function navigateToDashboard() {
            window.location.href = "{{ route('director.dashboard') }}";
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", loadAllocations);
    </script>
</body>
</html>