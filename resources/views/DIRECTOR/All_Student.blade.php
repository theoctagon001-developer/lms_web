<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        
        .container {
            max-width: 1280px;
        }
        
        .page-title {
            font-size: 1.875rem;
            background: linear-gradient(90deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 1.5rem;
        }
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 40;
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            max-width: 1280px;
            margin: 0 auto;
        }
        
        /* Footer styling */
        .footer {
            background-color: #1e40af;
            color: white;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }
        
        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .footer-copyright {
            font-size: 0.875rem;
            text-align: center;
        }
        
        /* Card styling */
        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Button styling */
        .btn {
            @apply font-medium py-2 px-4 rounded transition-all duration-300;
        }
        
        .btn-primary {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }
        
        .btn-secondary {
            @apply bg-purple-600 text-white hover:bg-purple-700;
        }
        
        .btn-small {
            @apply py-1 px-3 text-sm;
        }
        
        /* Search container */
        .search-card {
            border-radius: 0.75rem;
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .search-input {
            @apply border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200;
        }
        
        .search-select {
            @apply border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200;
        }
        
        /* Table styling - Updated header style */
        .student-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .student-table th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.025em;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        
        .student-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .student-table tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .student-table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* Profile image styling */
        .profile-image {
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            object-fit: cover;
            object-position: center;
            border: 2px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        
        .profile-image:hover {
            transform: scale(1.1);
        }
        
        /* Badge styling */
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-section {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-program {
            background-color: #e0e7ff;
            color: #4338ca;
        }
        
        /* CGPA indicator */
        .cgpa-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 1rem;
            color: white;
        }
        
        /* Action buttons container */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Modal styles - Updated modal card style */
        .modal-enter {
            opacity: 0;
            transform: translateY(-20px);
        }

        .modal-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms, transform 300ms;
        }

        .modal-exit {
            opacity: 1;
        }

        .modal-exit-active {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 300ms, transform 300ms;
        }

        /* Enrollment list styling */
        .enrollment-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .enrollment-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .enrollment-item:last-child {
            border-bottom: none;
        }

        .enrollment-course {
            font-weight: 500;
            color: #1f2937;
        }

        .enrollment-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-completed {
            background-color: #f0f9ff;
            color: #075985;
        }
        
        /* Updated modal card style */
        .modal-card {
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            background-color: #f8fafc;
            display: flex;
            justify-content: flex-end;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .table-container {
                overflow-x: auto;
                border-radius: 0.5rem;
            }
            
            /* Card-style table transformation for mobile */
            .mobile-card-view table, 
            .mobile-card-view thead, 
            .mobile-card-view tbody, 
            .mobile-card-view th, 
            .mobile-card-view td, 
            .mobile-card-view tr {
                display: block;
            }

            .mobile-card-view thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .mobile-card-view tr {
                margin-bottom: 1rem;
                border-radius: 0.75rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                background-color: white;
                border: 1px solid #e5e7eb;
                overflow: hidden;
            }

            .mobile-card-view td {
                border: none;
                position: relative;
                padding-left: 50% !important;
                text-align: left !important;
                min-height: 45px;
                display: flex;
                align-items: center;
                border-bottom: 1px solid #f0f0f0;
            }

            .mobile-card-view td:last-child {
                border-bottom: none;
            }

            .mobile-card-view td:before {
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

            /* Style for image and action cells */
            .mobile-card-view td:first-child {
                padding: 1rem !important;
                display: flex;
                justify-content: center;
                background-color: #f3f4f6;
            }

            .mobile-card-view td:first-child:before {
                display: none;
            }

            .mobile-card-view td:last-child {
                padding: 1rem !important;
                display: flex;
                justify-content: space-between;
                gap: 0.5rem;
            }

            .mobile-card-view td:last-child:before {
                display: none;
            }
            
            .mobile-card-view .action-buttons {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }
            
            .mobile-card-view .btn {
                flex: 1;
            }
            
            /* Style for CGPA in mobile view */
            .mobile-card-view .cgpa-cell {
                justify-content: flex-start;
            }
            
            .mobile-card-view .cgpa-indicator {
                margin-left: auto;
            }
            
            /* Responsive modal */
            .modal-card {
                margin: 1rem;
                width: calc(100% - 2rem);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Updated top bar -->
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

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-center page-title">Student Management System</h2>

        <div class="search-card">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Search Students</h3>
            
            <div class="flex flex-wrap items-end justify-center gap-4 search-container">
                <div class="w-full sm:w-auto">
                    <label for="search-name" class="block text-sm font-medium text-gray-700 mb-1">Name or Reg No</label>
                    <input type="text" id="search-name" class="search-input w-full" oninput="searchStudents()" placeholder="Enter name or registration number">
                </div>
                
                <div class="w-full sm:w-auto">
                    <label for="search-section" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <input type="text" id="search-section" class="search-input w-full" oninput="searchStudents()" placeholder="Enter section">
                </div>

                <div class="w-full sm:w-auto">
                    <label for="search-cgpa" class="block text-sm font-medium text-gray-700 mb-1">CGPA Condition</label>
                    <select id="search-cgpa" class="search-select w-full" onchange="searchStudents()">
                        <option value="greater">≥ Greater than</option>
                        <option value="equal">= Equal to</option>
                        <option value="less">≤ Less than</option>
                    </select>
                </div>
                
                <div class="w-full sm:w-auto">
                    <label for="cgpa-value" class="block text-sm font-medium text-gray-700 mb-1">CGPA Value</label>
                    <input type="number" id="cgpa-value" class="search-input w-full" oninput="searchStudents()" placeholder="e.g. 3.5" step="0.01">
                </div>

                <button onclick="resetSearch()" class="btn bg-gray-600 text-white hover:bg-gray-700 w-full sm:w-auto">
                    <i class="fas fa-sync-alt mr-1"></i> Reset Filters
                </button>
            </div>
        </div>

        <div class="card table-container overflow-hidden">
            <div id="loading-indicator" class="flex justify-center items-center py-12" style="display: none;">
                <div class="loading-spinner"></div>
                <span class="ml-3 font-medium text-blue-600">Loading students...</span>
            </div>
            
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>CGPA</th>
                        <th>Guardian</th>
                        <th>Section</th>
                        <th>Program</th>
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="student-table-body">
                    <tr>
                        <td colspan="10" class="text-center py-8">
                            <div class="loading-spinner mx-auto mb-2"></div>
                            <div class="text-gray-500">Loading student data...</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 text-center text-gray-500 text-sm">
            Showing <span id="student-count">0</span> students
        </div>
    </div>

    <!-- Updated Enrollment Modal -->
    <div id="enrollment-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <!-- Modal content - Updated with new card style -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full modal-card">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title">
                        Student Enrollments
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Current Enrollments -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-blue-600 mb-2">Current Enrollments</h4>
                            <div id="current-enrollments" class="min-h-20">
                                <p class="text-gray-500">Loading current courses...</p>
                            </div>
                        </div>
                        
                        <!-- Previous Enrollments -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-purple-600 mb-2">Previous Enrollments</h4>
                            <div id="previous-enrollments" class="min-h-20">
                                <p class="text-gray-500">Loading previous courses...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeEnrollmentModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated Footer -->
    <footer class="footer">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-copyright">
                    © Sharjeel | Ali | Sameer Learning Management System
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add Inter font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <script>
        let students = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentStudentId = null;

        // Check for mobile view and apply appropriate class
        function checkMobileView() {
            const tableContainer = document.querySelector('.table-container');
            if (window.innerWidth <= 768) {
                tableContainer.classList.add('mobile-card-view');
            } else {
                tableContainer.classList.remove('mobile-card-view');
            }
        }

        // Modal functions
        function openEnrollmentModal(studentId) {
            currentStudentId = studentId;
            document.getElementById('enrollment-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            loadEnrollments(studentId);
        }

        function closeEnrollmentModal() {
            document.getElementById('enrollment-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            currentStudentId = null;
        }

        // Load enrollments for a student
    async function loadEnrollments(studentId) {
    try {
        // Show loading states
        document.getElementById('current-enrollments').innerHTML = 
            '<div class="flex justify-center items-center h-20"><div class="loading-spinner"></div></div>';
        document.getElementById('previous-enrollments').innerHTML = 
            '<div class="flex justify-center items-center h-20"><div class="loading-spinner"></div></div>';
        
        // Fetch all enrollments in a single call
        const response = await fetch(`${API_BASE_URL}api/Students/getAllEnrollments?student_id=${studentId}`);
        const data = await response.json();
        
        // Render enrollments
        renderEnrollments(data);
    } catch (error) {
        console.error("Error fetching enrollments:", error);
        document.getElementById('current-enrollments').innerHTML = 
            '<p class="text-red-500">Error loading enrollments</p>';
        document.getElementById('previous-enrollments').innerHTML = 
            '<p class="text-red-500">Error loading enrollments</p>';
    }
}

 function renderEnrollments(data) {
    // Render current enrollments
    const currentContainer = document.getElementById('current-enrollments');
    if (data.success && data.CurrentCourses && data.CurrentCourses.length > 0) {
        currentContainer.innerHTML = `
            <ul class="enrollment-list">
                ${data.CurrentCourses.map(course => `
                    <li class="enrollment-item">
                        <span class="enrollment-course">${course.course_name || 'N/A'} (${course.course_code || 'N/A'})</span>
                        <span class="enrollment-status status-active">Active</span>
                        <div class="text-sm text-gray-500 mt-1">
                            Type: ${course.Type || 'N/A'} | 
                            Credit Hours: ${course.credit_hours || 'N/A'} | 
                            Section: ${course.section || 'N/A'}
                        </div>
                        ${course.teacher_name ? `<div class="text-sm text-gray-500">Teacher: ${course.teacher_name}</div>` : ''}
                    </li>
                `).join('')}
            </ul>
        `;
    } else {
        currentContainer.innerHTML = '<p class="text-gray-500">No current enrollments found</p>';
    }
    
    // Render previous enrollments
    const previousContainer = document.getElementById('previous-enrollments');
    if (data.success && data.PreviousCourses && Object.keys(data.PreviousCourses).length > 0) {
        let previousHtml = '';
        
        // Loop through each session in PreviousCourses
        for (const [session, courses] of Object.entries(data.PreviousCourses)) {
            previousHtml += `
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700 mb-2">${session}</h5>
                    <ul class="enrollment-list">
                        ${courses.map(course => `
                            <li class="enrollment-item">
                                <span class="enrollment-course">${course.course_name || 'N/A'} (${course.course_code || 'N/A'})</span>
                                <span class="enrollment-status ${course.grade === 'F' ? 'bg-red-100 text-red-800' : 'status-completed'}">
                                    ${course.grade || 'N/A'}
                                </span>
                                <div class="text-sm text-gray-500 mt-1">
                                    Type: ${course.Type || 'N/A'} | 
                                    Credit Hours: ${course.credit_hours || 'N/A'} | 
                                    Section: ${course.section || 'N/A'}
                                </div>
                                ${course.result_info && typeof course.result_info === 'object' ? `
                                    <div class="text-sm text-gray-500">
                                        Mid: ${course.result_info.mid || 'N/A'} | 
                                        Final: ${course.result_info.final || 'N/A'} | 
                                        Lab: ${course.result_info.lab || 'N/A'}
                                    </div>
                                ` : ''}
                            </li>
                        `).join('')}
                    </ul>
                </div>
            `;
        }
        
        previousContainer.innerHTML = previousHtml;
    } else {
        previousContainer.innerHTML = '<p class="text-gray-500">No previous enrollments found</p>';
    }
}

        function formatDate(dateString) {
            if (!dateString) return '';
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadStudents() {
            try {
                document.getElementById('loading-indicator').style.display = 'flex';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/AllStudent`);
                const data = await response.json();
                if (data.Student) {
                    students = data.Student;
                    renderStudents(students);
                }
                document.getElementById('loading-indicator').style.display = 'none';
            } catch (error) {
                console.error("Error fetching students:", error);
                document.getElementById('loading-indicator').style.display = 'none';
                document.getElementById("student-table-body").innerHTML = 
                    '<tr><td colspan="10" class="text-center py-4 text-red-500">Failed to load students. Please try again.</td></tr>';
            }
        }

        function getCgpaColor(cgpa) {
            if (cgpa >= 3.7) return 'bg-green-500';
            if (cgpa >= 3.0) return 'bg-blue-500';
            if (cgpa >= 2.5) return 'bg-yellow-500';
            return 'bg-red-500';
        }

        function searchStudents() {
            const searchQuery = document.getElementById("search-name").value.toLowerCase();
            const sectionQuery = document.getElementById("search-section").value.toLowerCase();
            const cgpaFilter = document.getElementById("search-cgpa").value;
            const cgpaValue = parseFloat(document.getElementById("cgpa-value").value);

            let filteredStudents = students.filter(student => {
                const matchName = student.RegNo.toLowerCase().includes(searchQuery) ||
                                 student.name.toLowerCase().includes(searchQuery);

                const matchSection = student.section_id.toLowerCase().includes(sectionQuery);

                const matchCgpa = !cgpaValue ? true : (
                    cgpaFilter === "greater" ? student.cgpa >= cgpaValue :
                    cgpaFilter === "less" ? student.cgpa <= cgpaValue :
                    student.cgpa == cgpaValue
                );

                return matchName && matchSection && matchCgpa;
            });

            renderStudents(filteredStudents);
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-section").value = "";
            document.getElementById("search-cgpa").value = "greater";
            document.getElementById("cgpa-value").value = "";
            renderStudents(students);
        }

        function renderStudents(studentList) {
            const tableBody = document.getElementById("student-table-body");
            tableBody.innerHTML = "";

            if (studentList.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center py-8 text-gray-500">No students found. Try refining your search.</td></tr>';
                return;
            }

            studentList.forEach(student => {
                const encodedData = btoa(JSON.stringify(student));
                const studentDetailsUrl = `{{ route('Director.details', ['student' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', encodedData);
                const cgpaColorClass = getCgpaColor(student.cgpa);
                
                tableBody.innerHTML += `
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-4 py-2" data-label="Profile">
                            <img src="${student.image || '{{ asset('images/male.png') }}'}" alt="${student.name}" 
                                class="profile-image mx-auto">
                        </td>
                        <td class="px-4 py-2" data-label="Reg No">
                            <div class="font-semibold text-gray-800">${student.RegNo}</div>
                        </td>
                        <td class="px-4 py-2" data-label="Name">
                            <div class="font-semibold text-gray-800">${student.name}</div>
                        </td>
                        <td class="px-4 py-2 cgpa-cell" data-label="CGPA">
                            <div class="cgpa-indicator ${cgpaColorClass}">${student.cgpa}</div>
                        </td>
                        <td class="px-4 py-2" data-label="Guardian">
                            <div class="text-gray-600">${student.guardian}</div>
                        </td>
                        <td class="px-4 py-2" data-label="Section">
                            <span class="badge badge-section">${student.section_id}</span>
                        </td>
                        <td class="px-4 py-2" data-label="Program">
                            <span class="badge badge-program">${student.program.name}</span>
                        </td>
                        <td class="px-4 py-2" data-label="Session">
                            <div class="text-sm text-gray-600">${student.session.name}-${student.session.year}</div>
                        </td>
                        <td class="px-4 py-2" data-label="Actions">
                            <div class="action-buttons">
                                <a href="${studentDetailsUrl}" class="btn btn-primary btn-small">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <button onclick="openEnrollmentModal('${student.id}')" class="btn btn-secondary btn-small">
                                    <i class="fas fa-book mr-1"></i> Courses
                                </button>
                            </div>
                        </td>
                    </tr>`;
            });
            
            // Update student count
            document.getElementById('student-count').textContent = studentList.length;
        }

        // Close modal when clicking outside
        document.getElementById('enrollment-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEnrollmentModal();
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('enrollment-modal').classList.contains('hidden')) {
                closeEnrollmentModal();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            loadStudents();
            checkMobileView();
            window.addEventListener('resize', checkMobileView);
            const searchCard = document.querySelector('.search-card');
            searchCard.classList.add('animate-fade-in');
        });
    </script>
</body>
</html>